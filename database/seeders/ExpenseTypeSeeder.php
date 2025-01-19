<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpenseType;
use Illuminate\Support\Facades\File;

class ExpenseTypeSeeder extends Seeder
{
   
    public function run()
    {
        $jsonFile = database_path('seed_assets/datas/expense_type.json');
        
        if (File::exists($jsonFile)) {
        
            $jsonData = File::get($jsonFile);
            $expenses = json_decode($jsonData, true);
            foreach ($expenses as $expense) {
                ExpenseType::create($expense);
            }

        } else {
            $this->command->error('JSON file does not exist!');
        }
    }
}
