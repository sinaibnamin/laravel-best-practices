<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $guarded = ['created_at','updated_at'];


    public function expense_type()
    {
        return $this->belongsTo(ExpenseType::class);
    }



}
