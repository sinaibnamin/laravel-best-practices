<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{

     public function index()
    {
        $expense_types = ExpenseType::orderByDesc('updated_at')
        ->withCount('expenses')
        ->get();
    
        return view('admin.pages.expense_type.list')->with('expense_types', $expense_types);
    }

   
    public function create()
    {
        return view('admin.pages.expense_type.input');
    }


   
    public function store(Request $request)
    {

        if($this->app_environment == 'demo'){
            return $this->flash_and_back('success', 'Expense type created');
        }


        $validatedData = $request->validate([
            'title' => 'required|unique:expense_types,title|max:255',
            'description' => 'max:500',
            'status' => 'required|in:Active,Inactive',
        ]);
       
        $expense_type = new ExpenseType;
        $expense_type->title = $request->title;
        $expense_type->description = $request->description;     
        $expense_type->status = $request->status;

        $expense_type->save();

        return $this->flash_and_back('success', 'Expense type created');
    }

   
    public function show(ExpenseType $expense_type)
    {
        //
    }

   
    public function edit($id)
    {          
        $page_type = 'edit'; 
        $expense_type = ExpenseType::where('id', $id)->first();
        return view('admin.pages.expense_type.input')->with('expense_type', $expense_type)->with('page_type', $page_type);
    }



  
    public function update(Request $request, $id)
    {

        if($this->app_environment == 'demo'){
            return $this->flash_and_back( 'success', "Expense type updated" );
        }

        $expense_type = ExpenseType::findOrFail($id);

        // dd($expense_type->id);

        $validatedData = $request->validate([
            'title' => 'required|unique:expense_types,title,' . $expense_type->id . '|max:255',
            'description' => 'max:500',
       
            'status' => 'required|in:Active,Inactive',
        ]);

        $expense_type->title = $request->title;
        $expense_type->description = $request->description;
      
        $expense_type->status = $request->status;
       
        $expense_type->save();

        return $this->flash_and_back( 'success', "Expense type updated" );
 
    }



    public function change_status( $status, $id ) {


        if($this->app_environment == 'demo'){
            return $this->flash_and_back( 'success', "expense type $status successfully" );
        }

        $expense_type = ExpenseType::findOrFail( $id );

        // Update the status of the expense_type
        $expense_type->status = $status;
        $expense_type->save();

        // Return a success message
        return $this->flash_and_back( 'success', "expense type $status successfully" );
    }





  

    public function delete($id)
    {


        if($this->app_environment == 'demo'){
            return $this->flash_and_back( 'danger', "Expense type deleted" );
        }


        $expense_type = ExpenseType::findOrFail($id);

        $Expenses = Expense::where('expense_type_id', $id)->first();
        
        if($Expenses){           
            return $this->flash_and_back( 'warning', "you can not delete $expense_type->name because it has some expenses" );
        };
      
        $expense_type->delete();

        return $this->flash_and_back( 'danger', "Expense type deleted" );

    }
  
  
}
