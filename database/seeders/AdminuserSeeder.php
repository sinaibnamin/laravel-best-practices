<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Adminuser;


class AdminuserSeeder extends Seeder
{
    public function run()
    {
        $adminusers = [
            [
                'username' => 'gymforest_admin',
                'name' => 'Gymforest Admin',
                'role' => 'admin',
                // 'password' => "44RRAD890abc945",
                'password' => '$2a$12$ZYQFxdTgemPK/tmymSuu6uvV8ML9rVge87Rmxjha3sz.W8yJGy.zS',
            ],
            [
                'username' => 'gymforest_admin_test',
                'name' => 'Gymforest Admin Test',
                'role' => 'admin',
                // 'password' => "44RRAD890abc945",
                'password' => '$2a$12$ZYQFxdTgemPK/tmymSuu6uvV8ML9rVge87Rmxjha3sz.W8yJGy.zS',
            ],
            [
                'username' => 'gymforest_admin_dev_9563',
                'name' => 'Gymforest Admin Dev',
                'role' => 'developer',
                // 'password' => "44RRAD890abc945",
                'password' => '$2a$12$ZYQFxdTgemPK/tmymSuu6uvV8ML9rVge87Rmxjha3sz.W8yJGy.zS',
            ]
            ,[
                'username' => 'gymforest_operator',
                'name' => 'Gymforest Operator',
                'role' => 'operator',
                // 'password' => "9087Hgd897dg",
                'password' => '$2a$12$.3iF7nom40PKrqB2ALdTDOEwDuozOj/K02LDdhn/NEzsOsv4EK5RG',
            ]
          
        ];

        foreach ($adminusers as $adminuser) {
            Adminuser::create($adminuser);
        }
    }
}
