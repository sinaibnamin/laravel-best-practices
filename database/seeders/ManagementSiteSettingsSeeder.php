<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ManagementSiteSettings;

class ManagementSiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $system_info = [
                'system_name' => 'Hammer Fitness Club',
                'routine' => '<figure class="table"><table><thead><tr><th>Day</th><th>Opening time</th><th>Break</th><th>Closing time</th></tr></thead><tbody><tr><td>Saturday</td><td>7:45 AM</td><td>1:15 PM to 2:30 PM</td><td>10:30 PM</td></tr><tr><td>Sunday</td><td>7:45 AM</td><td>1:15 PM to 2:30 PM</td><td>10:30 PM</td></tr><tr><td>Monday</td><td>7:45 AM</td><td>1:15 PM to 2:30 PM</td><td>10:30 PM</td></tr><tr><td>Tuesday</td><td>7:45 AM</td><td>1:15 PM to 2:30 PM</td><td>10:30 PM</td></tr><tr><td>Wednesday</td><td>7:45 AM</td><td>1:15 PM to 2:30 PM</td><td>10:30 PM</td></tr><tr><td>Thrusday</td><td>7:45 AM</td><td>1:15 PM to 2:30 PM</td><td>10:30 PM</td></tr></tbody></table></figure><p><strong>Note: </strong><span style="color:hsl(0,75%,60%);"><strong>Only females are allowed Sunday and Tuesday from 2:45 PM to 8:30 PM</strong></span></p>',                
                'print_header' => '<p style="text-align:center;">
                        <span style="font-size:36px;"><strong>Hammer Fitness Club</strong></span>
                    </p>
                    <p style="text-align:center;">
                        <span style="font-size:18px;">Address: 334/B CDA Avenue, MM Ali Road (2nd Floor)Lalkhan Bazar, Chattogram.</span>
                    </p>
                    <p style="text-align:center;">
                        <span style="font-size:18px;">Email: hammerfitnessclub@gmail.com / Phone: 01619366888, 01704385784</span>
                    </p>',                
                'sms_alert_enable' => 'false',                
                'online_payment_enable' => 'false',                
        ];

       
        ManagementSiteSettings::create($system_info);
    
    }
}
