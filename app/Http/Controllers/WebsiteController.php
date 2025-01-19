<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\SiteInfo;
use Carbon\Carbon;
use App\Models\ManagementSiteSettings;
use Redirect;

use Cookie;


class WebsiteController extends Controller
{
    public function index()
    {        
        // $site_info = SiteInfo::find(1);
        $system_info = ManagementSiteSettings::select('system_name', 'system_logo')->where('id', 1)->first();
     
        $system_name = $system_info->system_name ?? 'Gymnasium';
        $system_logo = $system_info->system_logo;
      
        return view('website.master')
        ->with('system_logo',$system_logo)
        ->with('system_name',$system_name);
    }
    

   
}
