<?php

namespace App\Http\Controllers;

use App\Models\ManagementSiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use ZipArchive;
use Illuminate\Support\Facades\File;

class ManagementSiteSettingsController extends Controller
{
   
    public function index()
    {
        
    }
    public function system_info()
    {
        $system_info = ManagementSiteSettings::where('id', 1)->first();
        return view('admin/pages/setting/system_info')->with('system_info', $system_info);
    }
    public function edit_gym_schedule()
    {
        $system_schedule = ManagementSiteSettings::select('routine')->where('id', 1)->first()->routine;
        return view('admin/pages/setting/system_schedule')->with('system_schedule', $system_schedule);
    }


    public function gym_schedule_update(Request $request)
    {


        if($this->app_environment == 'demo'){
            return $this->flash_and_back('success', 'Information updated!');
        }

        $validatedData = $request->validate([
            'routine' => 'nullable',
        ]);

        $system_info = ManagementSiteSettings::find(1);

        $system_info->routine = $request->routine;

        $system_info->save();

        return $this->flash_and_back('success', 'Information updated!');
    }
    public function system_info_update(Request $request)
    {


        if($this->app_environment == 'demo'){
            return $this->flash_and_back('success', 'Information updated!');
        }


        // dd($request->all());

        $validatedData = $request->validate([
            'system_name' => 'required',
            'print_header' => 'nullable',
            'system_logo' => 'nullable|image|max:500|dimensions:max_width=2000,max_height=2000', 
            'system_icon' => 'nullable|image|max:500|dimensions:max_width=1000,max_height=1000',  
        ]);

     

        $system_info = ManagementSiteSettings::find(1);

        $system_info->system_name = $request->system_name;
        $system_info->print_header = $request->print_header;


        if ($request->hasFile('system_logo')) {


            if (File::exists(public_path("/site_images/uploaded/system_info/" . $system_info->system_logo))) {
                File::delete(public_path("/site_images/uploaded/system_info/" . $system_info->system_logo));
            }


            $system_info->system_logo = $this->optimize_move_image(
                file: $request->system_logo,
                destinationPath: public_path('/site_images/uploaded/system_info'),
                height: 200,
            );
        }    

        if ($request->hasFile('system_icon')) {

            if (File::exists(public_path("/site_images/uploaded/system_info/" . $system_info->system_icon))) {
                File::delete(public_path("/site_images/uploaded/system_info/" . $system_info->system_icon));
            }

            $system_info->system_icon = $this->optimize_move_image(
                file: $request->system_icon,
                destinationPath: public_path('/site_images/uploaded/system_info'),
                height: 40,
            );
        }    

        $system_info->save();

        return $this->flash_and_back('success', 'Information updated!');
    }
    

  



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ManagementSiteSettings  $managementSiteSettings
     * @return \Illuminate\Http\Response
     */
    public function show(ManagementSiteSettings $managementSiteSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ManagementSiteSettings  $managementSiteSettings
     * @return \Illuminate\Http\Response
     */
    public function edit(ManagementSiteSettings $managementSiteSettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ManagementSiteSettings  $managementSiteSettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ManagementSiteSettings $managementSiteSettings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ManagementSiteSettings  $managementSiteSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManagementSiteSettings $managementSiteSettings)
    {
        //
    }
}
