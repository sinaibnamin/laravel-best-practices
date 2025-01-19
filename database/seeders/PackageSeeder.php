<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Package; 
use Illuminate\Support\Facades\File;


class PackageSeeder extends Seeder
{
    public function run()
    {
      
        $jsonFile = database_path('seed_assets/datas/packages.json');
        
      
        if (File::exists($jsonFile)) {
        
            $jsonData = File::get($jsonFile);
            
          
            $packages = json_decode($jsonData, true);
            
         
            foreach ($packages as $package) {
                Package::create($package);
            }

        } else {
            $this->command->error('JSON file does not exist!');
        }
    }
}