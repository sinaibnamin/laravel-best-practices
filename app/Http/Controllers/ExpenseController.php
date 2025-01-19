<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use App\Models\ManagementSiteSettings;

class ExpenseController extends Controller
{

    public function index(Request $request)
    {
        $print_page = $request->segment(3) === 'print';
        $print_header = '';
 
        $expense_types = ExpenseType::where('status', 'Active')->orderBy('created_at', 'desc')->get();

        $view_page = $print_page ? 'admin.pages.expense.print' : 'admin.pages.expense.list';
        $expenses = [];
        $total_expense = 0;
   
        if ($request->query() === []) {
            return view($view_page, compact('expenses', 'expense_types', 'total_expense',  'print_header', 'print_page'));
        }
        
        $query = Expense::query();
    
        if ($request->filled('expense_type_id')) {
            $query->where('expense_type_id', $request->expense_type_id);
        }
    
      

        if ($request->from_date != '') {
            $query->where('date', '>=', $request->from_date);
        }

        if ($request->to_date != '') {
            $query->where('date', '<=', $request->to_date);
        }
    
      
        $expenses = $query->orderBy('created_at', 'desc')->get();
      
        $total_expense = $expenses->sum('amount');
 
    

        if($print_page){
            $system_info = ManagementSiteSettings::select('print_header')->first();
            $print_header = $system_info ? $system_info->print_header : null;
        }
       
        return view($view_page, compact('expenses', 'expense_types', 'total_expense', 'print_header', 'print_page'));
    }
    

    public function create() {
        $expense_types = ExpenseType::orderBy( 'created_at', 'desc' )->where( 'status', 'Active' )->get();
        return view( 'admin.pages.expense.input' )
        ->with( 'expense_types', $expense_types );
    }

    public function store( Request $request ) {

        if ( $this->app_environment == 'demo' ) {
            return $this->flash_and_back( 'success', 'Expense add successfull' );
        }

        $validatedData = $request->validate([
            'expense_type_id' => 'required|exists:expense_types,id|max:255',
            'amount' => 'required|integer|max:10000000',
            'date' => 'required|date',
            'description' => 'nullable|max:1000',
        ]);


        $expense = new Expense;
        $expense->expense_type_id = $request->expense_type_id;
        $expense->amount = $request->amount;
        $expense->date = $request->date;
        $expense->description = $request->description;
        $expense->save();

        return $this->flash_and_back('success', 'Expense successfull');
       
    }


    public function show(Expense $expense)
    {
        //
    }

   
    public function edit($id)
    {          
        $page_type = 'edit'; 
   
        $expense_types = ExpenseType::orderBy( 'created_at', 'desc' )->where( 'status', 'Active' )->get();

        $expense = Expense::findorfail($id);
        return view( 'admin.pages.expense.input' )
        ->with( 'expense_types', $expense_types )
        ->with( 'expense', $expense )
        ->with('page_type', $page_type);

    }

    public function update(Request $request, $id)
    {
       

        if($this->app_environment == 'demo'){
            return $this->flash_and_back( 'success', "Expense updated" );
        }

        $expense = Expense::findOrFail($id);

        $validatedData = $request->validate([
            'expense_type_id' => 'required|exists:expense_types,id|max:255',
            'amount' => 'required|integer|max:10000000',
            'date' => 'required|date',
            'description' => 'nullable|max:1000',
        ]);

        $expense->expense_type_id = $request->expense_type_id;
        $expense->amount = $request->amount;
        $expense->date = $request->date;
        $expense->description = $request->description;
        $expense->save();

      

        return $this->flash_and_back('success', 'Expense updated');
 
    }


    public function destroy(Expense $expense)
    {
        //
    }


    public function delete($id, Request $request)
    {

        if($this->app_environment == 'demo'){
            return $this->flash_and_back('danger', 'Expense permanently deleted!'); 
        }
        
        $expense = Expense::find($id);
        if (!$expense) {
            return $this->flash_and_back('warning', 'Expense already deleted or not found');    
        }
        
        $expense->delete();
        
        return $this->flash_and_back('danger', 'Expense permanently deleted!'); 
    }



 
}
