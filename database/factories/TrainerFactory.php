<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Traits\FileHandlerTrait; // Import the trait

class TrainerFactory extends Factory
{
    use FileHandlerTrait; // Use the FileHandlerTrait

    public function definition()
    {
        static $counter = 1; // Static variable to keep track of the image number
        $generateUniqueBangladeshiPhoneNumber = '01' . fake()->unique()->numberBetween(100000000, 999999999);
    
        $districts = ['Dhaka', 'Chittagong', 'Khulna', 'Rajshahi', 'Sylhet', 'Barisal', 'Rangpur', 'Comilla'];
        $subDistricts = ['Dhanmondi', 'Gulshan', 'Mirpur', 'Bashundhara', 'Mohammadpur', 'Banani', 'Uttara'];
    
        // Define lists of Bangladeshi first and last names
        $firstNames = ['Arif', 'Fatema', 'Rafiq', 'Nasima', 'Shahin', 'Mita', 'Sohail', 'Sultana', 'Kamruzzaman', 'Nusrat'];
        $lastNames = ['Hossain', 'Rahman', 'Chowdhury', 'Ahmed', 'Khan', 'Siddique', 'Islam', 'Miah', 'Ali', 'Mollah'];

        $minDateOfBirth = now()->subYears(50); // 50 years ago
        $maxDateOfBirth = now()->subYears(25); // 25 years ago

        // Construct the image name
        $imageName = 'trainer_' . $counter . '.jpg';

        // Copy the image from the seed_assets directory to the destination
        $this->copyImage(base_path('database/seed_assets/images/trainers/' . $imageName), public_path('site_images/uploaded/trainer_images/' . $imageName));

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
            'password' => Hash::make('123456'),
            'status' => fake()->randomElement(['Active','Active']),
            'image' => $imageName, // Use the constructed image name
        ];
    }
}
