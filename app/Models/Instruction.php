<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    use HasFactory;
    protected $guarded = ['created_at','updated_at'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}
