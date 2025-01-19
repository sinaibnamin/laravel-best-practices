<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Member; 
use Illuminate\Support\Facades\File;

class MemberSeeder extends Seeder
{
   
    public function run()
    {
      
        $jsonFile = database_path('seed_assets/datas/members.json');
        
      
        if (File::exists($jsonFile)) {
        
            $jsonData = File::get($jsonFile);
            
          
            $members = json_decode($jsonData, true);
            
            foreach ($members as $member) {
                member::create($member);
            }

        } else {
            $this->command->error('JSON file does not exist!');
        }
    }
}
