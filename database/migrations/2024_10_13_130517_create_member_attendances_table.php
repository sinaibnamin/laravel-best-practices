<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::create('member_attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->nullable();
            $table->date('attendance_date')->index();
            $table->timestamps();
            $table->unique(['member_id', 'attendance_date']);
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('member_attendances');
    }
};
