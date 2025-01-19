<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Add this import
use Illuminate\Support\Facades\File; // Import for file handling
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UtilityController extends Controller
{
    public function downloadRandomImages()
    {
        $folderPath = public_path('download_random_images'); // Folder path

        // Create the folder if it doesn't exist
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true); // Create the directory with proper permissions
        }

        // Store hashes of downloaded images to prevent duplicates
        $imageHashes = [];
        $imageCount = 0;

        while ($imageCount < 50) {
            $response = Http::get('https://xsgames.co/randomusers/avatar.php?g=male');
            if ($response->successful()) {
                $imageContent = $response->body();
                $imageHash = md5($imageContent); // Calculate the hash of the image content

                // Check if the image hash is already in the list
                if (!in_array($imageHash, $imageHashes)) {
                    $imageCount++;
                    $imageFileName = "user_{$imageCount}.jpg"; // Name the image file
                    $imageFilePath = $folderPath . '/' . $imageFileName; // Set the file path

                    // Save the image content to the file
                    File::put($imageFilePath, $imageContent);

                    $imageHashes[] = $imageHash; // Add the hash to the list
                }
            } else {
                return response()->json(['error' => 'Failed to download image from API'], 500);
            }
        }

        return response()->json([
            'message' => 'Images downloaded successfully',
            'folder_path' => asset('download_random_images') 
        ], 200);
    }

    // public function tableDataToJson()
    // {
    //     $pdo = new \PDO('mysql:host=127.0.0.1;dbname=hr_club_old', 'root', '');
        
    //     $connection = new \Illuminate\Database\MySqlConnection($pdo);
        
    //     $query = $connection->table('package')->get();
        
    //     $modifiedQuery = $query->map(function ($item) {
         
    //         return [
    //             'id' => $item->pid,
    //             'name' => $item->packName,
    //             'price' => $item->packAmount,
    //             'duration' => $item->packDetails,
    //             'discount' => 0,    
    //         ];
    //     });
    
    //     return response()->json($modifiedQuery);
    // }



    public function tableDataToJson()
    {
        
        $pdo = new \PDO('mysql:host=127.0.0.1;dbname=hr_club_old', 'root', '');
        
        $connection = new \Illuminate\Database\MySqlConnection($pdo);
        
        $query = $connection->table('members')->get();

        $hash_pass = Hash::make('123456');

        $modifiedQuery = $query->map(function ($item) use($hash_pass) {
            $yearOfBirth = now()->year - (int)$item->mAge;
            $dateOfBirth = "{$yearOfBirth}-01-01"; 
            $status = Carbon::parse($item->mendDate)->lessThan(today()) ? 'Expire' : 'Active';
            $status = Carbon::parse($item->mendDate)->isBefore(today()->subMonths(2)) ? 'Archive' : $status;
            

            return [
                'id' => $item->mid,
                'full_name' => $item->mName,
                'nid' => 123456789,
                'address' => $item->mAddress,
                'email' => $item->mEmail,
                'date_of_birth' => $dateOfBirth,
                'gender' => $item->mGender,
                'phone_number' => $item->mMobile,
                'emergency_contact_name' => 'Kamrul Hasan',
                'emergency_contact_relationship' => 'Father',
                'emergency_contact_phone' => '01111111111',
                'medical_conditions_details' => 'good condition',
                'fitness_goals' => 'weight loss',
                'image' => $item->mImage,
                'status' => $status,
                'password' => $hash_pass,
                'uniq_id' => $item->mCode,
                'blood_group' => $item->mblood,
                'profession' => $item->mProf,
                'weight' => $item->mWeight,
                'neck' => $item->mNeck,
                'shoulder' => $item->mShoulder,
                'chest' => $item->mChest,
                'abdomen' => $item->mAbdomen,
                'waist' => $item->mWaist,
                'marital_status' => $item->mMarried,
                'validity' => $item->mendDate,
    
            ];
        });
    
        return response()->json($modifiedQuery);
    }
    






}
