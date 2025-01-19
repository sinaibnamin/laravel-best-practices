<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Models\Member;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use App\Models\ManagementSiteSettings;

class TrainerController extends Controller
{

    public function index(Request $request)
    {      
        $trash_page = false;
      
        $segments = $request->segments();
        $lastSegment = Arr::last($segments);
        if($lastSegment == 'trashlist'){
            $trash_page = true;
        }

        $query = Trainer::query();

        if ($request->full_name != '') {
            $query->where('full_name', 'LIKE', "%{$request->full_name}%" );
        }

        if ($request->phone_number != '') {
            $query->where('phone_number', 'LIKE', "%{$request->phone_number}%" );
        }
       
        if ($request->status != "all" && $request->status != "") {
            $query->where('status', $request->status );    
        }

        if($trash_page == true){
            $query->where('status', '=', 'Trash')->orderBy('updated_at', 'desc');
        }else{
            $query->where('status', '!=', 'Trash')->orderBy('created_at', 'desc');
        }
       
        $trainers = $query->paginate(30);

        return view('admin.pages.trainer.list')
        ->with('trainers', $trainers)
        ->with('trash_page', $trash_page)
        ;
    }

    public function trashlist(Request $request)
    {
        $trainers = Trainer::where('status', '=', 'Trash')->orderBy('updated_at', 'desc')->paginate(30);
        return view('admin.pages.trainer.list')->with('trainers', $trainers);
    }

    public function create()
    {
        return view('admin.pages.trainer.input');
    }

    public function store(Request $request)
    {      

        if($this->app_environment == 'demo'){
            return $this->flash_and_back('success', 'Trainer created!');
        }

        $validatedData = $request->validate([          
            'full_name' => 'nullable|max:255',
            'nid' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'email' => 'nullable|max:255',
            'date_of_birth' => 'nullable|date|max:255',
            'gender' => 'nullable|max:255',
            'phone_number' => 'required|unique:trainers,phone_number',
            'emergency_contact_name' => 'nullable|max:255',
            'emergency_contact_relationship' => 'nullable|max:255',
            'emergency_contact_phone' => 'nullable',
            'password' => 'required|max:20|min:5',  
            'image' => 'nullable|image|mimes:jpg,png,jpeg,webp|dimensions:min_width=200,min_height=200|max:5000|min:5',

        ]);      
        
     
       
        $trainer = new Trainer;
        $trainer->full_name = $request->full_name;  
        $trainer->nid = $request->nid;  
        $trainer->address = $request->address;  
        $trainer->email = $request->email;  
        $trainer->date_of_birth = $request->date_of_birth;  
        $trainer->gender = $request->gender;  
        $trainer->phone_number = $request->phone_number;  
        $trainer->emergency_contact_name = $request->emergency_contact_name;  
        $trainer->emergency_contact_relationship = $request->emergency_contact_relationship;  
        $trainer->emergency_contact_phone = $request->emergency_contact_phone;  
       
        $trainer->password = Hash::make($request->password);     
        $trainer->status = "Pending";   
        
        if ($request->hasFile('image')) {
          
            $trainer->image = $this->optimize_move_image(
                file: $request->image,
                destinationPath: public_path('/site_images/uploaded/trainer_images'),
            );
        }     
       
        $trainer->save();

        return $this->flash_and_back('success', 'Trainer created!');
       
    }

    public function show($id)
    {       
        $trainer = Trainer::where('id', $id)->first();
        if(!$trainer){
            abort(404);
        };    
        return view('admin.pages.trainer.show')->with('trainer', $trainer);
    }
  

  

   

    public function edit($id)
    {
        $page_type = 'edit';
        $trainer = Trainer::where('id', $id)->first();
        return view('admin.pages.trainer.input')
        ->with('trainer', $trainer)
        ->with('page_type', $page_type);
    }

    public function update(Request $request, $id = null)
    {

        if($this->app_environment == 'demo'){
            return $this->flash_and_back('success', 'Trainer updated!');
        }

        // dd($request->all());

        if(get_user_role() == 'trainer'){
            $trainer = Trainer::where('phone_number', get_user_id())->first();
        }else{
            $trainer = Trainer::findOrFail($id);
        }

        if(!$trainer){
            return $this->flash_and_back('danger', 'Trainer not found');
        };     

      
        $validation_rules = [          
            'full_name' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'nid' => 'nullable|max:255',
            'email' => 'nullable|max:255',
            'date_of_birth' => 'nullable|date|max:255',
            'gender' => 'nullable|max:255',
            'emergency_contact_name' => 'nullable|max:255',
            'emergency_contact_relationship' => 'nullable|max:255',
            'emergency_contact_phone' => 'nullable',
            'password' => 'nullable|max:20|min:5',  
            'image' => 'nullable|image|mimes:jpg,png,jpeg,webp|dimensions:min_width=200,min_height=200|max:5000|min:5',
        ];

        if ($trainer->status == "Active") {
            $validation_rules['full_name'] = 'required|max:255';
            $validation_rules['nid'] = 'required|max:255';
            $validation_rules['address'] = 'required|max:255';
            $validation_rules['date_of_birth'] = 'required|date|max:255';
            $validation_rules['gender'] = 'required|max:255';
            $validation_rules['emergency_contact_phone'] = 'required';
        }

        if(get_user_role() == 'admin'){
            $validation_rules['phone_number'] = 'required|unique:trainers,phone_number,' . $trainer->id;
        }

        $validatedData = $request->validate($validation_rules);   

        if(get_user_role() == 'admin'){
            if($request->password){
                $trainer->password = Hash::make($request->password); 
            };
            $trainer->phone_number = $request->phone_number; 
        }

        $trainer->full_name = $request->full_name;  
        $trainer->nid = $request->nid;  
        $trainer->address = $request->address;  
        $trainer->email = $request->email;  
        $trainer->date_of_birth = $request->date_of_birth;  
        $trainer->gender = $request->gender;  
   
        $trainer->emergency_contact_name = $request->emergency_contact_name;  
        $trainer->emergency_contact_relationship = $request->emergency_contact_relationship;  
        $trainer->emergency_contact_phone = $request->emergency_contact_phone;  
     
        if($request->custom_img_edit_status_image == 'no'){

        }elseif ($request->custom_img_edit_status_image == 'deleted') {
            if (File::exists(public_path("/site_images/uploaded/trainer_images/" . $trainer->image))) {
                File::delete(public_path("/site_images/uploaded/trainer_images/" . $trainer->image));
            }
            $trainer->image = null;
        } elseif ($request->custom_img_edit_status_image == 'changed') {
            
            if ($request->hasFile('image')) {

                if (File::exists(public_path("/site_images/uploaded/trainer_images/" . $trainer->image))) {
                    File::delete(public_path("/site_images/uploaded/trainer_images/" . $trainer->image));
                }
    
                $trainer->image = $this->optimize_move_image(
                    file: $request->image,
                    destinationPath: public_path('/site_images/uploaded/trainer_images'),
                );
            }    

        }

        $trainer->save();
        return $this->flash_and_back('success', 'Trainer updated!');
  

    }




    public function change_status( $status, $id ) {

        if($this->app_environment == 'demo'){
            return $this->flash_and_back( 'success', "trainer $status successfully" );
        }

        $trainer = trainer::findOrFail( $id );

        if ( $status == 'Active' ) {
            // Use the Validator facade to validate the input data
            $validator = Validator::make( $trainer->toArray(), [
                'full_name' => 'required',
                'nid' => 'required',
                'address' => 'required',
                'date_of_birth' => 'required',
                'gender' => 'required',
                'phone_number' => 'required',
                'emergency_contact_phone' => 'required',               
            ] );

            // If validation fails, return with error
            if ( $validator->fails() ) {
                return redirect()->back()->withErrors( $validator )->withInput();
            }
         
        }


        // Update the status of the trainer
        $trainer->status = $status;
        $trainer->save();

        // Return a success message
        return $this->flash_and_back( 'success', "trainer $status successfully" );
    }
  
   
  


    public function delete($id, Request $request)
    {


        if($this->app_environment == 'demo'){
            return $this->flash_and_back('danger', 'Trainer permanently deleted!'); 
        }




        $trainer = Trainer::find($id);
        if(!$trainer){
            return $this->flash_and_back('warning', 'Trainer already deleted or not found');    
        };    
        if (File::exists(public_path("/site_images/uploaded/trainer_images/" . $trainer->image))) {
            File::delete(public_path("/site_images/uploaded/trainer_images/" . $trainer->image));
        }
        $trainer->delete();




        if(($request->profile_page == 'true')){
            $this->flash_msg('danger', 'Trainer permanently deleted!'); 
            return redirect('/admin_panel/trainer/list');
        }



        return $this->flash_and_back('danger', 'Trainer permanently deleted!'); 
    }



    //  for trainer panel 

    public function profile()
    {       
        $trainer = Trainer::where('phone_number', get_user_id())->first();
        if(!$trainer){
            abort(404);
        };    
        return view('admin.pages.trainer.show')
        ->with('trainer', $trainer)
        ->with('page_mode', 'trainer_view')
        ;
    }
    public function editprofile()
    {
        $page_type = 'edit';
        $user_mode = 'trainer';
        $trainer = Trainer::where('phone_number', get_user_id())->first();
        return view('admin.pages.trainer.input')
        ->with('trainer', $trainer)
        ->with('user_mode', $user_mode)
        ->with('page_type', $page_type);
    }

   

    public function trainer_panel_login()
    {
        $system_name = ManagementSiteSettings::select('system_name')->where('id', 1)->first()->system_name ?? 'Gymnasium';
        return view('admin.login')->with('panel_type', 'trainer_panel')->with('system_name', $system_name);
    }
  
    public function trainer_panel_login_check(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|max:255',     
            'password' => 'required|max:255',     
        ]);

        $input_username = $request->username;
        $input_password = $request->password;

        $finduser = Trainer::where('phone_number', $request->username)->first();
        if(!$finduser){
            return Redirect::back()->withErrors(['msg' => 'Wrong information (01)']);
        }
       
        $hashcheck = Hash::check($input_password ,$finduser->password);
       
        if(!$hashcheck){
            return Redirect::back()->withErrors(['msg' => 'Wrong information (02)']);
        }

        // check if is active or pending
        if (!in_array($finduser->status, ['Active', 'Pending'])) {
            return redirect()->back()->withErrors(['msg' => 'Your account is not active. Please contact the admin.']);
        }

        $cookie_info = [
            'username' => $finduser->phone_number, 
            'name' => $finduser->full_name, 
            'password' => $finduser->password,
            'role' => 'trainer',
        ];
        
        Cookie::queue(Cookie::make('trainer_cookie', json_encode($cookie_info), 10080));
       
       
        return redirect('/trainer_panel');
    }

    public function changepassword(Request $request)
    {
      return view('admin.pages.setting.changepassword')->with('panel_type', 'trainer_panel');
    }

    public function updatepassword(Request $request)
    {

        if($this->app_environment == 'demo'){
            return $this->flash_and_back('success', 'password updated!');
        }

        // dd($request->all());
        $validatedData = $request->validate([
            'old_password' => 'required|max:255',
            'new_password' => 'required|max:255',           
            'retype_new_password' => 'required|max:255',           
        ]);

        $input_old_password = $request->old_password;
     
        if($request->new_password !== $request->retype_new_password){
            return $this->flash_and_back('warning', 'new password and re-type new password not match'); 
        }

        $get_cookie = Cookie::get('trainer_cookie');

        if (!$get_cookie) {
            Cookie::queue(Cookie::forget('trainer_cookie'));
            return redirect('/trainer_panel/login');
        }

        $cookie_username = json_decode($get_cookie)->username;

        $finduser = Trainer::where('phone_number', $cookie_username)->first();


        if(!$finduser){
            return Redirect::back()->withErrors(['msg' => 'Wrong information']);
        }
       
        $hashcheck = Hash::check($input_old_password ,$finduser->password);
       
        if(!$hashcheck){
            return Redirect::back()->withErrors(['msg' => 'please enter old password correctly!']);
        }

        $hashed_pass = Hash::make($request->new_password);


        $finduser->password = $hashed_pass;
       
        $finduser->save();

        $cookie_info = [
            'username' => $finduser->phone_number, 
            'name' => $finduser->full_name, 
            'password' => $finduser->password,
            'role' => 'trainer',
        ];
        Cookie::queue(Cookie::make('trainer_cookie', json_encode($cookie_info), 10080));
        return $this->flash_and_back('success', 'password updated!');
    }


   
}
