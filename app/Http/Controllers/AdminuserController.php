<?php

namespace App\Http\Controllers;

use App\Models\Adminuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use App\Models\ManagementSiteSettings;

class AdminuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $system_name = ManagementSiteSettings::select('system_name')->where('id', 1)->first()->system_name ?? 'Gymnasium';
        return view('admin.login')->with('system_name',$system_name);
    }
    public function logout()
    {
        Cookie::queue(Cookie::forget('admin_cookie'));
        Cookie::queue(Cookie::forget('member_cookie'));
        Cookie::queue(Cookie::forget('trainer_cookie'));
        return redirect('/');
    }
    public function check(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|max:255',     
            'password' => 'required|max:255',     
        ]);

        $input_username = $request->username;
        $input_password = $request->password;

        $finduser = Adminuser::where('username', $request->username)->first();
        if(!$finduser){
            return Redirect::back()->withErrors(['msg' => 'Wrong information']);
        }
       
        $hashcheck = Hash::check($input_password ,$finduser->password);
       
        if(!$hashcheck){
            return Redirect::back()->withErrors(['msg' => 'Wrong information']);
        }

        $cookie_info = [
            'username' => $finduser->username, 
            'name' => $finduser->name, 
            'password' => $finduser->password,
            'role' => $finduser->role,
        ];
        
        Cookie::queue(Cookie::make('admin_cookie', json_encode($cookie_info), 10080));
       
       
        return redirect('/admin_panel');
    }

    public function changepassword(Request $request)
    {
      return view('admin.pages.setting.changepassword');
    }



    public function updatepassword(Request $request)
    {
      
     
        if($this->app_environment == 'demo'){
            return $this->flash_and_back('success', 'password updated!'); 
        }

        $validatedData = $request->validate([
            'old_password' => 'required|max:255',
            'new_password' => 'required|max:255',           
            'retype_new_password' => 'required|max:255',           
        ]);

        $input_old_password = $request->old_password;
     
        if($request->new_password !== $request->retype_new_password){
            Session::flash('message', 'new password and re-type new password not match'); 
            Session::flash('alert-class', 'danger'); 
            Session::flash('icon-class', 'fa-solid fa-triangle-exclamation'); 
            return redirect()->back();     
        }

        $get_cookie = Cookie::get('admin_cookie');

        if (!$get_cookie) {
            Cookie::queue(Cookie::forget('admin_cookie'));
            return redirect('/admin_panel/login');
        }

        $cookie_username = json_decode($get_cookie)->username;

        $finduser = Adminuser::where('username', $cookie_username)->first();


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
            'username' => $finduser->username, 
            'name' => $finduser->name, 
            'password' => $finduser->password,
            'role' => $finduser->role,
        ];
        
        Cookie::queue(Cookie::make('admin_cookie', json_encode($cookie_info), 10080));

        return $this->flash_and_back('success', 'password updated!'); 
    }












    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Adminuser  $adminuser
     * @return \Illuminate\Http\Response
     */
    public function show(Adminuser $adminuser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Adminuser  $adminuser
     * @return \Illuminate\Http\Response
     */
    public function edit(Adminuser $adminuser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adminuser  $adminuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Adminuser $adminuser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adminuser  $adminuser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adminuser $adminuser)
    {
        //
    }
















}
