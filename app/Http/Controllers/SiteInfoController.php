<?php

namespace App\Http\Controllers;

use App\Models\SiteInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;

class SiteinfoController extends Controller
{
      
    public function edit()
    {
        $siteinfo = Siteinfo::where('id', 1)->first();
        return view('admin.pages.siteinfo.edit')->with('siteinfo', $siteinfo);
    }

 
    public function update(Request $request)
    {

        if($this->app_environment == 'demo'){
            return $this->flash_and_back( 'success', "Info Updated!" );
        }


        // dd($request->all());
        $siteinfo = Siteinfo::find(1);

        $validatedData = $request->validate([
            'site_title' => 'required',
            'site_description' => 'required',

            'site_headline_en' => 'required',
            'site_headline_bn' => 'required',
            'site_subheadline_en' => 'required',
            'site_subheadline_bn' => 'required',

            'site_footnote_en' => 'required',
            'site_footnote_bn' => 'required',

            'site_facebook' => 'required',
            'site_twitter' => 'required',
            'site_instagram' => 'required',
            'site_linkedin' => 'required',
        ]);
      
        $siteinfo->site_title = $request->site_title;
        $siteinfo->site_description = $request->site_description;

        $siteinfo->site_headline_en = $request->site_headline_en;
        $siteinfo->site_headline_bn = $request->site_headline_bn;
        $siteinfo->site_subheadline_en = $request->site_subheadline_en;
        $siteinfo->site_subheadline_bn = $request->site_subheadline_bn;

        $siteinfo->site_footnote_en = $request->site_footnote_en;
        $siteinfo->site_footnote_bn = $request->site_footnote_bn;

        $siteinfo->site_facebook = $request->site_facebook;
        $siteinfo->site_twitter = $request->site_twitter;
        $siteinfo->site_instagram = $request->site_instagram;
        $siteinfo->site_linkedin = $request->site_linkedin;

        $siteinfo->save();

       
        return $this->flash_and_back( 'success', "Info Updated!" );
    }



// api 

public function publicinfo()
{
    $siteinfo = Siteinfo::where('id', 1)->first();
    return response(['status' => 'ok', 'error' => false, 'siteinfo' => $siteinfo], 200);  
}

public function siteheadline()
{
    $siteheadline = Siteinfo::where('id', 1)->select('siteheadline','sitedescription')->first();
    return response(['status' => 'ok', 'error' => false, 'siteheadline' => $siteheadline], 200);  
}

public function siteaboutsummary()
{
    $siteaboutsummary = Siteinfo::where('id', 1)->select('aboutsummary')->first();
    return response(['status' => 'ok', 'error' => false, 'siteaboutsummary' => $siteaboutsummary], 200);  
}

public function siteaboutdetails()
{
    $siteaboutdetails = Siteinfo::where('id', 1)->select('aboutdetails')->first();
    return response(['status' => 'ok', 'error' => false, 'siteaboutdetails' => $siteaboutdetails], 200);  
}

public function sitefooterinfo()
{
    $sitefooterinfo = Siteinfo::where('id', 1)->select(
        'companylinks',
        'quicklinks',
        'footerlogotext',
        'phone',
        'location',
        'email',
        'facebook',
        'twitter',
        'youtube',
        'linkedin',
        )->first();
    return response(['status' => 'ok', 'error' => false, 'sitefooterinfo' => $sitefooterinfo], 200);  
}

public function sitecontactinfo()
{
    $sitecontactinfo = Siteinfo::where('id', 1)->select(      
        'phone',
        'location',
        'email',
        )->first();
    return response(['status' => 'ok', 'error' => false, 'sitecontactinfo' => $sitecontactinfo], 200);  
}





 
}
