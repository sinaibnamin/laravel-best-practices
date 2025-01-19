<?php

namespace Database\Factories;

use App\Models\MemberAttendance;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberAttendanceFactory extends Factory
{
    protected static $counter = 0;

    public function definition()
    {
        // Get the total number of members, ensuring it's cast to an integer
        $total_member = (int) env('SEED_MEMBER');

        // Calculate the current date
        $currentDate = now()->startOfDay();

        // Use the static counter to set the member_id
        $member_id = (self::$counter % $total_member) + 1; // Ensures we loop back to 1 if we exceed $total_member

        // Subtract days from the current date only when member_id is 1
        if ($member_id === 1) {
            $attendance_date = $currentDate->subDays((self::$counter / $total_member))->format('Y-m-d'); // Subtracts the days based on how many loops have occurred
        } else {
            $attendance_date = $currentDate->subDays((self::$counter / $total_member))->format('Y-m-d');
        }

        self::$counter++; // Increment the counter for the next factory call

        return [
            'member_id' => $member_id,
            'attendance_date' => $attendance_date,
        ];
    }
}
