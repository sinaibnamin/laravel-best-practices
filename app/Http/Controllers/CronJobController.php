<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\Member;
use App\Models\Payment;
use App\Models\CronJobReport;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Artisan;
use ZipArchive;
use File;
use Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Models\ManagementSiteSettings;
use App\Models\SmsCounter;

class CronJobController extends Controller {

    public function updatememberstatus() {
        try {
            // Expire members and log the results
            $expiredMembers = $this->expireMembers();
            $this->logCronJobReportExpireMember($expiredMembers);
    
            // Archive members and log the results
            $archivedMembers = $this->archiveMembers();
            $this->logCronJobReportArchiveMember($archivedMembers);
    
            return response()->json(['message' => 'Member statuses updated successfully.']);
    
        } catch (\Exception $e) {
            $reportMessage = 'Failed to update member statuses. Please try again later. Error message: ' . $e->getMessage();
    
            CronJobReport::create([
                'type' => 'member_status_update',
                'report' => $reportMessage,
                'error' => 'error',
            ]);
    
            return response()->json(['error' => 'Failed to update member statuses. Please try again later.'], 500);
        }
    }
    
    private function expireMembers() {
        $expiredMemberDetails = [];
        $today = Carbon::today()->startOfDay();
        $batchSize = 1000;
    
        DB::table('members')
            ->where('validity', '<', $today)
            ->whereNotIn('status', ['Expire', 'Archive'])
            ->orderBy('id')
            ->chunkById($batchSize, function ($members) use (&$expiredMemberDetails) {
                $ids = $members->pluck('id')->toArray();
                Member::whereIn('id', $ids)->update(['status' => 'Expire']);
                
                foreach ($members as $member) {
                    $expiredMemberDetails[] = "<p>{$member->full_name} (phone: {$member->phone_number}, Uniq id: {$member->uniq_id})</p>";
                }
            });
    
        return $expiredMemberDetails;
    }
    
    private function archiveMembers() {
        $archivedMemberDetails = [];
        $twoMonthsAgo = Carbon::today()->subMonths(2)->startOfDay();
        $batchSize = 1000;
    
        DB::table('members')
            ->where('validity', '<', $twoMonthsAgo)
            ->where('status', '!=', 'Archive')
            ->orderBy('id')
            ->chunkById($batchSize, function ($members) use (&$archivedMemberDetails) {
                $ids = $members->pluck('id')->toArray();
                Member::whereIn('id', $ids)->update(['status' => 'Archive']);
    
                foreach ($members as $member) {
                    $archivedMemberDetails[] = "<p>{$member->full_name} (phone: {$member->phone_number}, Uniq id: {$member->uniq_id})</p>";
                }
            });
    
        return $archivedMemberDetails;
    }
    
    private function logCronJobReportExpireMember($updatedMembers) {
        if (empty($updatedMembers)) {
            $reportMessage = 'No member expired today.';
        } else {
            $memberDetails = implode(' ', $updatedMembers);
            $reportMessage = '<b>Software automation expired the following members:</b> <div>' . $memberDetails . '</div>';
        }
    
        CronJobReport::create([
            'type' => 'member_expire_check',
            'report' => $reportMessage,
            'error' => 'no_error',
        ]);
    }
    
    private function logCronJobReportArchiveMember($archivedMembers) {
        if (empty($archivedMembers)) {
            $reportMessage = 'No member archived today.';
        } else {
            $memberDetails = implode(' ', $archivedMembers);
            $reportMessage = '<b>Software automation archived the following members:</b> <div>' . $memberDetails . '</div>';
        }
    
        CronJobReport::create([
            'type' => 'member_archive_check',
            'report' => $reportMessage,
            'error' => 'no_error',
        ]);
    }
    


    // fail payments delete start
    
    public function deleteFailedPayments() {
        try {
            $deletedPaymentsCount = $this->removeFailedPayments();
            $this->logFailedPaymentsDeletion($deletedPaymentsCount);
    
            return response()->json(['message' => 'Failed payments deleted.']);
        } catch (\Exception $e) {
            $reportMessage = 'Failed to delete failed payments. Please try again later. Error message: ' . $e->getMessage();
    
            CronJobReport::create([
                'type' => 'failed_payment_deletion',
                'report' => $reportMessage,
                'error' => 'error',
            ]);
    
            return response()->json(['error' => 'Failed to delete failed payments. Please try again later.'], 500);
        }
    }
    
    private function removeFailedPayments() {
        $twoMonthsAgo = Carbon::today()->subMonths(2)->startOfDay();       
    
        $deletedCount = Payment::where('status', 'fail')
            ->where('date', '<', $twoMonthsAgo)
            ->delete();
    
        return $deletedCount;
    }
    
    private function logFailedPaymentsDeletion($deletedCount) {
        if ($deletedCount === 0) {
            $reportMessage = 'No failed payments deleted today.';
        } else {
            $reportMessage = "Deleted {$deletedCount} failed payments today.";
        }
    
        CronJobReport::create([
            'type' => 'failed_payment_deletion',
            'report' => $reportMessage,
            'error' => 'no_error',
        ]);
    }
    
    // fail payments delete end


    // expire sms alert start 

    public function sendExpireAlertSms() {
        try {
            // Check if SMS alerts are enabled
            $sms_alert_enable = ManagementSiteSettings::select('sms_alert_enable')
                ->where('id', 1)
                ->first()
                ->sms_alert_enable ?? 'false';
    
            if ($sms_alert_enable === 'false') {
                throw new \Exception('<span class="text-danger text-bold">SMS alerts are currently disabled.</span>');
            }
    
            // Send alerts and log the results
            $alertedMembers = $this->sendExpireAlerts();
            $this->logCronJobReportExpireAlert($alertedMembers);
    
            return response()->json(['message' => 'Expire alerts sent successfully.']);
        } catch (\Exception $e) {
            // Handle errors
            $errorMessage = 'Failed to send expire alerts. Error: ' . $e->getMessage();
            $this->logCronJobError($errorMessage);
    
            return response()->json(['error' => $errorMessage], 500);
        }
    }
    
    private function sendExpireAlerts() {
        $alertedMemberDetails = [];
        $smsResponses = [];
        $twoDaysFromNow = Carbon::today()->addDays(2)->startOfDay();
        $batchSize = 1000;
    
        // Fetch system name from settings
        $system_name = ManagementSiteSettings::select('system_name')
            ->where('id', 1)
            ->first()
            ->system_name ?? 'Gymnasium';
    
        // Process members in chunks to avoid memory overload
        Member::whereDate('validity', '=', $twoDaysFromNow)
            ->where('status', 'Active')
            ->orderBy('id')
            ->chunk($batchSize, function ($members) use (&$alertedMemberDetails, &$smsResponses, $twoDaysFromNow, $system_name) {
                $phoneNumbers = [];
                foreach ($members as $member) {
                    $alertedMemberDetails[] = "<p>{$member->full_name} (phone: {$member->phone_number}, Uniq id: {$member->uniq_id})</p>";
                    $phoneNumbers[] = $member->phone_number;
                }
    
                if (!empty($phoneNumbers)) {
                    $message = "{$system_name}: Dear member, your Gymnasium membership will expire on {$twoDaysFromNow->format('d M Y')}.";
    
                    // Send SMS and handle response
                    $smsResponses[] = $this->sendSmsAndHandleResponse($message, $phoneNumbers);
                }
            });
    
        return ['details' => $alertedMemberDetails, 'responses' => $smsResponses];
    }
    
    private function sendSmsAndHandleResponse($message, $phoneNumbers) {
        $response = $this->sendSms($message, $phoneNumbers);
        $responseData = json_decode($response, true);
    
        if (isset($responseData['error']) && $responseData['error'] == 0) {
            // Success case: log the SMS count
            $smsCount = is_array($phoneNumbers) ? count($phoneNumbers) : count(explode(',', $phoneNumbers));
    
            SmsCounter::create([
                'count' => $smsCount,
                'date' => Carbon::today()->toDateString(),
            ]);
    
            return ['message' => 'SMS sent successfully.', 'error' => 'no_error'];
        }
    
        // Error case
        $errorMessage = $responseData['msg'] ?? 'Unknown error';
        return ['message' => "Error: {$errorMessage}", 'error' => 'error'];
    }
    
    
    private function sendSms($message, $phoneNumbers) {
        // SMS API details
        $url = "https://api.sms.net.bd/sendsms";
        $api_key = env('SMS_API_KEY'); 
    
        // Prepare phone numbers as a comma-separated string
        if (is_array($phoneNumbers)) {
            $phoneNumbers = implode(',', $phoneNumbers);
        }

        // dd($phoneNumbers);
    
     
        $queryString = http_build_query([
            'api_key' => $api_key,
            // 'msg' => $message,
            'msg' => 'প্রিয় সদস্য, আপনার জিমনেশিয়ামের মেম্বারশিপ রিনিউ করুন।',
            'content_id' => 1163,
            'to' => $phoneNumbers,
        ]);
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . "?" . $queryString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
        $response = curl_exec($ch);
    
        if (curl_errno($ch)) {
            $error_message = curl_error($ch);
            curl_close($ch);
            return json_encode(['error' => 1, 'msg' => $error_message]);
        }
    
        curl_close($ch);

        // return json_encode([
        //     'error' => 0,
        //     'msg' => 'Request successfully submitted'
        // ]);

        return $response;
    }
    
    private function logCronJobReportExpireAlert($alertedMembers) {
        $alertedMemberDetails = $alertedMembers['details'];
        $smsResponses = $alertedMembers['responses'];
    
        if (empty($alertedMemberDetails)) {
            $reportMessage = 'No expire alerts were sent today.';
            $error = 'no_error';
        } else {
            $memberDetails = implode(' ', $alertedMemberDetails);
            $smsResponseDetails = implode('<br>', array_map(function ($response) {
                return $response['message'];
            }, $smsResponses));
    
            $reportMessage = "<b>Software automation sent expire alerts to the following members:</b> <div>{$memberDetails}</div>" .
                             "<br><b>SMS sending response:</b><br>{$smsResponseDetails}";
            $error = $smsResponses[0]['error'] ?? 'error';
        }
    
        CronJobReport::create([
            'type' => 'member_expire_sms_alert',
            'report' => $reportMessage,
            'error' => $error,
        ]);
    }
    
    
    private function logCronJobError($message) {
        CronJobReport::create([
            'type' => 'member_expire_sms_alert',
            'report' => $message,
            'error' => 'error',
        ]);
    }
    


    // expire sms alert end












    public function downloadDailyBackup()
    {

        if($this->app_environment == 'demo'){
            return $this->flash_and_back('warning', 'Backup will not run on demo mode'); 
        }

        // Define paths
        $databaseDumpPath = storage_path('app/backup/database_backup.sql');
        $uploadFolderPath = public_path('site_images/uploaded');
        $zipFilePath = storage_path('app/backup/backup.zip');

        // Ensure backup directory exists
        $backupDir = storage_path('app/backup');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0775, true); // Create the directory if it doesn't exist
        }

        // Step 1: Manually generate SQL dump from the database
        $this->generateDatabaseBackup($databaseDumpPath);

        // Check if the database dump file exists
        if (!File::exists($databaseDumpPath)) {
            // If the file does not exist, handle the error
            return response()->json(['error' => 'Database dump failed to create.'], 500);
        }

        // Step 2: Create a ZIP file and add both the database dump and the uploaded images folder
        $zip = new ZipArchive();

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            // Add the database dump to the ZIP file
            $zip->addFile($databaseDumpPath, 'database_backup.sql');
            
            // Add the site images folder to the ZIP
            $this->addFolderToZip($zip, $uploadFolderPath, 'site_images/uploaded');
            
            $zip->close();
        }

        // Step 3: Clean up the database dump file (delete the SQL file after zipping)
        // File::delete($databaseDumpPath);

        // Step 4: Return the ZIP file as a download response with custom headers
        $response = response()->download($zipFilePath)
            ->deleteFileAfterSend(true); // Deletes the file after sending

        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }

    protected function generateDatabaseBackup($filePath)
    {
        $tables = DB::select('SHOW TABLES');
        $sql = '';

        foreach ($tables as $table) {
            $tableName = $table->{"Tables_in_" . env('DB_DATABASE')}; // Get the table name
            
            // Get the table creation query
            $createTableQuery = DB::select("SHOW CREATE TABLE $tableName");
            $sql .= "\n\n" . $createTableQuery[0]->{'Create Table'} . ";\n\n";
            
            // Get all data for the table
            $rows = DB::table($tableName)->get();

            foreach ($rows as $row) {
                $columns = [];
                $values = [];

                foreach ($row as $column => $value) {
                    $columns[] = "`$column`";
                    $values[] = "'" . addslashes($value) . "'"; // Escape the values
                }

                $sql .= "INSERT INTO `$tableName` (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ");\n";
            }
        }

        // Save the SQL dump to the specified file
        file_put_contents($filePath, $sql);
    }

    protected function addFolderToZip(ZipArchive $zip, $folder, $zipFolder)
    {
        $files = File::allFiles($folder);
        
        foreach ($files as $file) {
            $relativePath = $zipFolder . '/' . $file->getRelativePathname();
            $zip->addFile($file->getRealPath(), $relativePath);
        }
    }

   

   






    
    
}