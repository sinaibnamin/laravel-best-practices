<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\NewsSource;

class NewsSourceSeeder extends Seeder
{
   
    public function run()
    {
        $news_sources = [
            [
                'name_en'  => 'prothom alo',
                'name_bn'  => 'প্রথম আলো',
                'slug'  => 'prothom_alo',
            ]
            ,[
                'name_en'  => 'kaler kantho',
                'slug'  => 'kaler_kantho',
                'name_bn'  => 'কালের কণ্ঠ',
            ]
            ,[
                'name_en'  => 'bangladesh protidin',
                'slug'  => 'bangladesh_protidin',
                'name_bn'  => 'বাংলাদেশ প্রতিদিন',
            ]
            ,[
                'name_en'  => 'vorer kagoj',
                'slug'  => 'vorer_kagoj',
                'name_bn'  => 'ভোরের কাগজ',
            ]
            ,[
                'name_en'  => 'dainik azadi',
                'slug'  => 'dainik_azadi',
                'name_bn'  => 'দৈনিক আজাদি',
            ]
            ,[
                'name_en'  => 'dainik purbokon',
                'slug'  => 'dainik_purbokon',
                'name_bn'  => 'দৈনিক পুর্বকন',
            ]
            ,[
                'name_en'  => 'daily star',
                'slug'  => 'daily_star',
                'name_bn'  => 'ডেইলি স্টার',
            ]
           
        ];

        foreach ($news_sources as $news_source) {
            NewsSource::create($news_source);
        }
    }
}
