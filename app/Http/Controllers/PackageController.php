<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\Payment;

class PackageController extends Controller
{

    public function index()
    {

        $packages = Package::orderByDesc('updated_at')
        ->withCount('payments')
        ->when(get_user_role() == 'member', function ($query) {
            $query->where('price', '!=', 0)->where('status', 'Active');
        })
        ->get();
    


        return view('admin.pages.package.list')->with('packages', $packages);
    }

   
    public function create()
    {
        return view('admin.pages.package.input');
    }


   
    public function store(Request $request)
    {

        if($this->app_environment == 'demo'){
            return $this->flash_and_back('success', 'Package created');
        }


        $validatedData = $request->validate([
            'name' => 'required|unique:packages,name|max:255',
            'description' => 'max:500',
            'price' => 'required|integer|max:9999999',
            'discount' => 'required|integer|max:9999999',
            'duration' => 'required|integer',
            'status' => 'required|in:Active,Inactive',
        ]);
       
        $package = new Package;
        $package->name = $request->name;
        $package->description = $request->description;
        $package->price = $request->price;
        $package->duration = $request->duration;
        $package->status = $request->status;

        $package->save();

        return $this->flash_and_back('success', 'Package created');
    }

   
    public function show(Package $package)
    {
        //
    }

   
    public function edit($id)
    {          
        $page_type = 'edit'; 
        $package = Package::where('id', $id)->first();
        return view('admin.pages.package.input')->with('package', $package)->with('page_type', $page_type);
    }



  
    public function update(Request $request, $id)
    {

        if($this->app_environment == 'demo'){
            return $this->flash_and_back( 'success', "Package updated" );
        }



        $package = Package::findOrFail($id);

        // dd($package->id);

        $validatedData = $request->validate([
            'name' => 'required|unique:packages,name,' . $package->id . '|max:255',
            'description' => 'max:500',
            'price' => 'required|integer|max:9999999',
            'discount' => 'required|integer|max:9999999',
            'duration' => 'required|integer',
            'status' => 'required|in:Active,Inactive',
        ]);

        $package->name = $request->name;
        $package->description = $request->description;
        $package->price = $request->price;
        $package->discount = $request->discount;
        $package->duration = $request->duration;
        $package->status = $request->status;
       
        $package->save();

        return $this->flash_and_back( 'success', "Package updated" );
 
    }



    public function change_status( $status, $id ) {


        if($this->app_environment == 'demo'){
            return $this->flash_and_back( 'success', "package $status successfully" );
        }

        $package = Package::findOrFail( $id );

        // Update the status of the package
        $package->status = $status;
        $package->save();

        // Return a success message
        return $this->flash_and_back( 'success', "package $status successfully" );
    }





  

    public function delete($id)
    {


        if($this->app_environment == 'demo'){
            return $this->flash_and_back( 'danger', "Package deleted" );
        }


        $package = Package::findOrFail($id);

        $Payments = Payment::where('package_id', $id)->first();
        
        if($Payments){           
            return $this->flash_and_back( 'warning', "you can not delete $package->name because it has some payments" );
        };
      
        $package->delete();

        return $this->flash_and_back( 'danger', "Package deleted" );

    }
  
}
