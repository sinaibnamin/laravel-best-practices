<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\News;
use App\Models\Blog;
use App\Models\NewsCategory;
use App\Models\Report;
use App\Models\SiteInfo;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\Instruction;
use App\Models\PaymentType;
use App\Models\Payment;
use App\Models\Package;
use App\Models\Announcement;
use App\Models\ManagementSiteSettings;
use App\Models\MemberAttendance;
use App\Models\Expense;

class DatabaseSeeder extends Seeder
{
    public function run()
    {     
        // Clear specified folders
        $this->clearFolder('public/site_images/uploaded/trainer_images');
        $this->clearFolder('public/site_images/uploaded/member_images');
        $this->clearFolder('public/site_images/uploaded/system_info');

        $total_member = env('SEED_MEMBER', 24); 
        $total_trainer = env('SEED_TRAINER', 3); 
        $total_payment = $total_member * 5; 
        $total_package = 15; 
        $total_instruction = $total_member * 5; 
        $total_attendance = $total_member * 31 * 2; 

        $this->call(SiteInfoSeeder::class);
        $this->call(AdminuserSeeder::class);
        
        $this->call(AnnouncementSeeder::class);
        $this->call(ManagementSiteSettingsSeeder::class);
        $this->call(ExpenseTypeSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(MemberSeeder::class);
      
        // Member::factory()->count($total_member)->afterCreating(function (Member $member) {
        //     $member->uniq_id = env('GYM_BRANCH_CODE').str_pad($member->id, 3, '0', STR_PAD_LEFT);
        //     $member->save();
        // })
        // ->create();

        // Trainer::factory()->count($total_trainer)->create();
        // $this->call(PaymentTypeSeeder::class);        
        // Instruction::factory()->count($total_instruction)->create();
        // Payment::factory()->count($total_payment)->create();
        // Expense::factory()->count(50)->create();  
        // MemberAttendance::factory()->count($total_attendance)->create();
    }

    protected function clearFolder($path)
    {
        // Check if the folder exists
        if (is_dir($path)) {
            // Delete all files in the directory
            $files = glob($path . '/*'); // get all file names
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file); // delete file
                }
            }
        }
    }
}
