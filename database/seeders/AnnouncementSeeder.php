<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Announcement;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $announcements = [
            [
                'headline' => 'New Gym Equipment Arriving Soon!',
                'description' => 'We are excited to announce that new fitness equipment is being delivered to the gym next week. Stay tuned for more updates!',
                'type' => 'info',
                'priority' => '1',
                'status' => 'Inactive',
            ],
            [
                'headline' => 'Reminder: Maintenance Closure',
                'description' => 'The gym will be closed for routine maintenance on Sunday. We apologize for any inconvenience and appreciate your understanding.',
                'type' => 'warning',
                'priority' => '2',
                'status' => 'Inactive',
            ],
            [
                'headline' => 'New Yoga Class Available',
                'description' => 'Join our new yoga class starting next Monday! Sign up at the front desk or on our app to reserve your spot.',
                'type' => 'success',
                'priority' => '3',
                'status' => 'Active',
            ],
            [
                'headline' => 'Annual Membership Discount',
                'description' => 'We are offering a 10% discount on all annual memberships this month. Don’t miss this opportunity to save!',
                'type' => 'success',
                'priority' => '4',
                'status' => 'Inactive',
            ],
            [
                'headline' => 'New Trainer Available for Personal Sessions',
                'description' => 'We are pleased to introduce our new certified personal trainer! Book a session today and take your fitness to the next level.',
                'type' => 'info',
                'priority' => '2',
                'status' => 'Inactive',
            ],
            [
                'headline' => 'Emergency Fire Drill This Friday',
                'description' => 'Please be aware that we will be conducting an emergency fire drill this Friday at 3 PM. The gym will briefly close for safety procedures.',
                'type' => 'danger',
                'priority' => '13',
                'status' => 'Inactive',
            ],
            [
                'headline' => 'Pool Temporarily Closed for Cleaning',
                'description' => 'The pool will be closed for deep cleaning on Wednesday. We expect it to reopen by Thursday afternoon. Thank you for your patience.',
                'type' => 'warning',
                'priority' => '3',
                'status' => 'Active',
            ],
            [
                'headline' => 'Gym Opening Hours Extended',
                'description' => 'We are extending our gym hours to 11 PM starting this weekend. More time for you to achieve your fitness goals!',
                'type' => 'success',
                'priority' => '5',
                'status' => 'Inactive',
            ],
            [
                'headline' => 'Spin Class Canceled for Tomorrow',
                'description' => 'Due to unforeseen circumstances, tomorrow’s spin class is canceled. We apologize for any inconvenience and encourage you to attend our other available classes.',
                'type' => 'danger',
                'priority' => '2',
                'status' => 'Inactive',
            ],
            [
                'headline' => 'Member Feedback Survey Now Open',
                'description' => 'We value your feedback! Please fill out our quick survey to let us know how we can improve your gym experience.',
                'type' => 'info',
                'priority' => '4',
                'status' => 'Inactive',
            ],
        ];
        

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}
