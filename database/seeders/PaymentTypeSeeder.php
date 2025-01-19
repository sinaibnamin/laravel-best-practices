<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentType;

class PaymentTypeSeeder extends Seeder
{

   
    public function run()
    {
        $paymentTypes = [
            [
                'title' => 'Admission Fee',
                'description' => 'Fee for admission a member',
                'amount' => 3000,
                'status' => 'Active',
            ]
            ,[
                'title' => 'Monthly Fee January 2024',
                'description' => 'regular monthly fee',
                'amount' => 1000,
                'due_date' => '2024-01-30',
                'status' => 'Active',
            ]
            ,[
                'title' => 'Monthly Fee February 2024',
                'description' => 'regular monthly fee',
                'amount' => 1000,
                'due_date' => '2024-02-28',
                'status' => 'Active',
            ]
            ,[
                'title' => 'Monthly Fee March 2024',
                'description' => 'regular monthly fee',
                'amount' => 1000,
                'due_date' => '2024-03-30',
                'status' => 'Active',
            ]
            ,[
                'title' => 'Monthly Fee April 2024',
                'description' => 'regular monthly fee',
                'amount' => 1000,
                'due_date' => '2024-04-30',
                'status' => 'Active',
            ]
            ,[
                'title' => 'Monthly Fee May 2024',
                'description' => 'regular monthly fee',
                'amount' => 1000,
                'due_date' => '2024-05-30',
                'status' => 'Active',
            ]
            ,[
                'title' => 'Monthly Fee June 2024',
                'description' => 'regular monthly fee',
                'amount' => 1000,
                'due_date' => '2024-06-30',
                'status' => 'Active',
            ]
            ,[
                'title' => 'Monthly Fee July 2024',
                'description' => 'regular monthly fee',
                'amount' => 1000,
                'due_date' => '2024-07-30',
                'status' => 'Active',
            ]
            ,[
                'title' => 'Monthly Fee August 2024',
                'description' => 'regular monthly fee',
                'amount' => 1000,
                'due_date' => '2024-08-30',
                'status' => 'Active',
            ]
            ,[
                'title' => 'Fine',
                'description' => 'fee for any damage by someone',
                'status' => 'Active',
            ]



          
        ];

        foreach ($paymentTypes as $paymentType) {
            PaymentType::create($paymentType);
        }
    }
}
