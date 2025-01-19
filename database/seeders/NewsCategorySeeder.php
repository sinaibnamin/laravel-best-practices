<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\NewsCategory;

class NewsCategorySeeder extends Seeder
{
   
    public function run()
    {
        $news_categories = [
            [
                'name_en'  => 'Entertainment',
                'slug'  => 'entertainment',
                'name_bn'  => 'বিনোদন',
                'priority'  => '20',
                'status'  => 1,
            ]
            ,[
                'name_en'  => 'Sports',
                'slug'  => 'sports',
                'name_bn'  => 'খেলাধুলা',
                 'priority'  => '20',
                'status'  => 1,
            ]
            ,[
                'name_en'  => 'Politics',
                'slug'  => 'politics',
                'name_bn'  => 'রাজনীতি',
                 'priority'  => '20',
                'status'  => 1,
            ]
            ,[
                'name_en'  => 'Crime',
                'slug'  => 'crime',
                'name_bn'  => 'অপরাধ',
                 'priority'  => '20',
                'status'  => 1,
            ]
            ,[
                'name_en'  => 'Business',
                'slug'  => 'business',
                'name_bn'  => 'বাণিজ্য',
                 'priority'  => '20',
                'status'  => 1,
            ]
            ,[
                'name_en'  => 'Lifestyle',
                'slug'  => 'lifestyle',
                'name_bn'  => 'জীবনযাপন',
                 'priority'  => '20',
                'status'  => 1,
            ]
            ,[
                'name_en'  => 'International',
                'slug'  => 'international',
                'name_bn'  => 'আন্তর্জাতিক',
                 'priority'  => '20',
                'status'  => 1,
            ]
           
        ];

        foreach ($news_categories as $newscategory) {
            NewsCategory::create($newscategory);
        }
    }
}
