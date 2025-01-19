<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
   
    protected $guarded = ['created_at','updated_at'];

    public function news()
    {
        return $this->belongsTo(News::class);
    }

}
