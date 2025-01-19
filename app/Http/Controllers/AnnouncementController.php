<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $announcements = Announcement::orderBy('priority')->get();
        return view('admin.pages.announcement.list')->with('announcements', $announcements);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.pages.announcement.input');
    }

    
    public function store(Request $request)
    {
        if($this->app_environment == 'demo'){
            return $this->flash_and_back('success', 'Announcement created');
        }

        $validatedData = $request->validate([          
            'type' => 'required|max:255',
            'headline' => 'required|max:255',
            'description' => 'required|max:600',
            'status' => 'required|max:255',
            'priority' => 'required|max:255',
        ]);      
        
        $announcement = new Announcement;
        $announcement->type = $request->type;
        $announcement->headline = $request->headline;
        $announcement->description = $request->description;
        $announcement->status = $request->status;
        $announcement->priority = $request->priority;
         
        $announcement->save();

        return $this->flash_and_back('success', 'Announcement created');
    }

  
    public function show(Announcement $announcement)
    {
        //
    }

   

    public function edit($id)
    {          
        $page_type = 'edit'; 
        $announcement = Announcement::where('id', $id)->first();
        return view('admin.pages.announcement.input')->with('announcement', $announcement)->with('page_type', $page_type);
    }


    public function update(Request $request, $id)
    {

        if($this->app_environment == 'demo'){
            return $this->flash_and_back( 'success', "Announcement updated!" );
        }


        $announcement = Announcement::findOrFail($id);

        // dd($announcement->id);

        $validatedData = $request->validate([
            'type' => 'required|max:255',
            'headline' => 'required|max:255',
            'description' => 'required|max:600',
            'status' => 'required|max:255',
            'priority' => 'required|max:255',
        ]);

        $announcement->type = $request->type;
        $announcement->headline = $request->headline;
        $announcement->description = $request->description;
        $announcement->status = $request->status;
        $announcement->priority = $request->priority;

        $announcement->save();

        return $this->flash_and_back( 'success', "Announcement updated!" );
 
    }






    public function change_status( $status, $id ) {

        if($this->app_environment == 'demo'){
            return $this->flash_and_back( 'success', "announcement $status successfully" );
        }

        $announcement = Announcement::findOrFail( $id );

        // Update the status of the announcement
        $announcement->status = $status;
        $announcement->save();

        // Return a success message
        return $this->flash_and_back( 'success', "announcement $status successfully" );
    }




    public function delete($id)
    {

        if($this->app_environment == 'demo'){
            return $this->flash_and_back('danger', 'Announcement permanently deleted!'); 
        }



        $announcement = Announcement::find($id);
        if(!$announcement){
            return $this->flash_and_back('warning', 'Announcement already deleted or not found');    
        };    
      
        $announcement->delete();
        return $this->flash_and_back('danger', 'Announcement permanently deleted!'); 
    }
}
