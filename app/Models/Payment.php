<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = ['created_at','updated_at'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
