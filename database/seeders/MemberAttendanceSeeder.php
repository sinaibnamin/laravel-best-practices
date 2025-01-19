<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\MemberAttendance;

class MemberAttendanceSeeder extends Seeder
{
    

    public function run()
    {
        $total_attendance = $total_member * 15 * 2; // 2 month 
        // Specify the number of records you want to create
        $numberOfRecords = 50; // Adjust as needed

        // Create attendance records using the factory
       
        MemberAttendance::factory()->count($numberOfRecords)->create();
    }
}