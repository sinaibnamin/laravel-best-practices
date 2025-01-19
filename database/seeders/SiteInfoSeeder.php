<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SiteInfo;

class SiteInfoSeeder extends Seeder
{
   
    public function run()
    {
        $site_info = [
         
                'site_title'  => 'ShortsPaper | Read Less, know More',
                'site_description'  => 'Visit ShortsPaper to read the latest news headlines, reports, analysis, sports, entertainment, jobs, politics, and business from around the world including Bangladesh.',

                'site_headline_en'  => "Bangladesh's first news summary app - Shorts Paper",
                'site_headline_bn'  => 'বাংলাদেশের প্রথম সংবাদ সারসংক্ষেপ অ্যাপ-শর্টস পেপার',

                'site_subheadline_en'  => "In today's fast-paced life, know more in less time - Shorts Paper: Your Smart News Companion.",

                'site_subheadline_bn'  => 'আজকের দ্রুত গতির জীবনে, কম সময়ে বেশি জানুন - শর্টস পেপার: আপনার নিউজের স্মার্ট সঙ্গী।',

                'site_footnote_en'  => 'Did your tea get cold while reading the news?  Know everything in just a few minutes with Shorts Paper.',
              
                'site_footnote_bn'  => 'খবর পড়তে পড়তে চা ঠান্ডা হয়ে গেছে? শর্টস পেপার দিয়ে কয়েক মিনিটেই জেনে ফেলুন সব',

                'site_facebook'  => 'https://www.facebook.com/shortspaper',
                'site_twitter'  => 'https://www.facebook.com/shortspaper',
                'site_instagram'  => 'https://www.facebook.com/shortspaper',
                'site_linkedin'  => 'https://www.facebook.com/shortspaper',
              
        ];

      
        SiteInfo::create($site_info);
     
    }
}


