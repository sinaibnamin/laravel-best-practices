<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Traits\FileHandlerTrait;

class MemberFactory extends Factory
{
    use FileHandlerTrait;

    public function definition()
    {
        static $counter = 1; // Static variable to keep track of the image number
        $generateUniqueBangladeshiPhoneNumber = '01' . fake()->unique()->numberBetween(100000000, 999999999);
    
        $districts = ['Dhaka', 'Chittagong', 'Khulna', 'Rajshahi', 'Sylhet', 'Barisal', 'Rangpur', 'Comilla'];
        $subDistricts = ['Dhanmondi', 'Gulshan', 'Mirpur', 'Bashundhara', 'Mohammadpur', 'Banani', 'Uttara'];
    
        // Define lists of Bangladeshi first and last names
        $firstNames = ['Arif', 'Fatema', 'Rafiq', 'Nasima', 'Shahin', 'Mita', 'Sohail', 'Sultana', 'Kamruzzaman', 'Nusrat'];
        $lastNames = ['Hossain', 'Rahman', 'Chowdhury', 'Ahmed', 'Khan', 'Siddique', 'Islam', 'Miah', 'Ali', 'Mollah'];
    
        // Define a list of fitness goals
        $fitnessGoals = [
            'muscle building',
            'weight loss',
            'endurance training',
            'improving flexibility',
            'cardiovascular fitness',
            'strength training',
            'overall wellness',
            'sports performance',
            'body toning',
            'rehabilitation',
            'increasing stamina',
            'fat loss',
            'core strengthening',
            'yoga and meditation',
            'functional training'
        ];
    
        $minDateOfBirth = now()->subYears(50); // 50 years ago
        $maxDateOfBirth = now()->subYears(25); // 25 years ago

        // Construct the image name
        $imageName = 'user_' . $counter . '.jpg';

        // Copy the image from the seed_assets directory to the destination
        $this->copyImage(base_path('database/seed_assets/images/members/' . $imageName), public_path('site_images/uploaded/member_images/' . $imageName));

        // Increment the counter for the next iteration
        $counter++;

        return [
            'full_name' => fake()->randomElement($firstNames) . ' ' . fake()->randomElement($lastNames), 
            'nid' => fake()->unique()->numberBetween(10000000000, 99999999999), 
            'address' => fake()->buildingNumber() . ' ' . fake()->streetName() . ', ' . fake()->randomElement($subDistricts) . ', ' . fake()->randomElement($districts),
            'email' => fake()->unique()->safeEmail(),
            'username' => 'same_as_phone_number',
            'date_of_birth' => fake()->dateTimeBetween($minDateOfBirth, $maxDateOfBirth)->format('Y-m-d'), 
            'gender' => fake()->randomElement(['Male', 'Female', 'Other']),
            'phone_number' => $generateUniqueBangladeshiPhoneNumber,
            'emergency_contact_name' => fake()->randomElement($firstNames) . ' ' . fake()->randomElement($lastNames), 
            'emergency_contact_relationship' => fake()->randomElement(['Friend', 'Family', 'Colleague']), 
            'emergency_contact_phone' => $generateUniqueBangladeshiPhoneNumber, 
            'medical_conditions_details' => fake()->paragraph(1),
            'fitness_goals' => fake()->randomElement($fitnessGoals), 
            'password' => Hash::make('123456'),
            'status' => fake()->randomElement(['Active','Active','Active','Active','Active','Active','Active','Active','Active','Active','Active','Active','Active','Active','Active','Active', 'Pending', 'Inactive', 'Archive', 'Expire']),
            'image' => $imageName,

            'uniq_id' => str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT),
            'blood_group' => fake()->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'profession' => fake()->randomElement(['Doctor', 'Engineer', 'Teacher', 'Lawyer', 'Artist', 'Developer', 'Nurse', 'Designer', 'Writer', 'Accountant']),
            'weight' => fake()->numberBetween(50, 120), 
            'height' => fake()->numberBetween(150, 200), 
            'neck' => fake()->numberBetween(30, 50), 
            'shoulder' => fake()->numberBetween(40, 60), 
            'chest' => fake()->numberBetween(80, 120), 
            'abdomen' => fake()->numberBetween(70, 110), 
            'waist' => fake()->numberBetween(60, 100), 
            'marital_status' => fake()->randomElement(['Single', 'Married', 'Divorced', 'Widowed']),
            'package_id' => fake()->numberBetween(1, 12), 
            'validity' => fake()->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
 
        ];
    }
}
