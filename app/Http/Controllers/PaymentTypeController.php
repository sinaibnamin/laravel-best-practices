<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    public function index()
    {
        $payment_types = PaymentType::orderByDesc('updated_at')->withCount('payments')->paginate(10);
        return view('admin.pages.payment_type.list')->with('payment_types', $payment_types);
    }

   
    public function create()
    {
        return view('admin.pages.payment_type.input');
    }


   
    public function store(Request $request)
    {

        if($this->app_environment == 'demo'){
            return $this->flash_and_back('success', 'Payment type created');
        }





        $validatedData = $request->validate([
            'title' => 'required|unique:payment_types,title|max:255',
            'description' => 'max:500',
            'amount' => 'nullable|integer|max:100000',
            'due_date' => 'nullable|date',
            'status' => 'required|in:Active,Inactive',
        ]);
       
        $payment_type = new PaymentType;
        $payment_type->title = $request->title;
        $payment_type->description = $request->description;
        $payment_type->amount = $request->amount;
        $payment_type->due_date = $request->due_date;
        $payment_type->status = $request->status;

        $payment_type->save();

        return $this->flash_and_back('success', 'Payment type created');
    }

   
    public function show(PaymentType $payment_type)
    {
        //
    }

   
    public function edit($id)
    {          
        $page_type = 'edit'; 
        $payment_type = PaymentType::where('id', $id)->first();
        return view('admin.pages.payment_type.input')->with('payment_type', $payment_type)->with('page_type', $page_type);
    }



  
    public function update(Request $request, $id)
    {

        if($this->app_environment == 'demo'){
            return $this->flash_and_back( 'success', "Payment type updated" );
        }

        $payment_type = PaymentType::findOrFail($id);

        // dd($payment_type->id);

        $validatedData = $request->validate([
            'title' => 'required|unique:payment_types,title,' . $payment_type->id . '|max:255',
            'description' => 'max:500',
            'amount' => 'nullable|integer|max:100000',
            'due_date' => 'nullable|date',
            'status' => 'required|in:Active,Inactive',
        ]);

        $payment_type->title = $request->title;
        $payment_type->description = $request->description;
        $payment_type->amount = $request->amount;
        $payment_type->due_date = $request->due_date;
        $payment_type->status = $request->status;
       

        $payment_type->save();

        return $this->flash_and_back( 'success', "Payment type updated" );
 
    }



    public function change_status( $status, $id ) {


        if($this->app_environment == 'demo'){
            return $this->flash_and_back( 'success', "payment_type $status successfully" );
        }

        $payment_type = PaymentType::findOrFail( $id );

        // Update the status of the payment_type
        $payment_type->status = $status;
        $payment_type->save();

        // Return a success message
        return $this->flash_and_back( 'success', "payment_type $status successfully" );
    }





  

    public function delete($id)
    {


        if($this->app_environment == 'demo'){
            return $this->flash_and_back( 'danger', "Payment type deleted" );
        }


        $payment_type = PaymentType::findOrFail($id);

        $Payments = Payment::where('payment_type_id', $id)->first();
        
        if($Payments){           
            return $this->flash_and_back( 'warning', "you can not delete $payment_type->title because it has some payments" );
        };
      
        $payment_type->delete();

        return $this->flash_and_back( 'danger', "Payment type deleted" );

    }
}
