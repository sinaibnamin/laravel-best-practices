<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::create('adminusers', function (Blueprint $table) {
            $table->id();
            $table->text('username')->nullable();
            $table->text('name')->nullable();
            $table->text('password')->nullable();
            $table->text('role')->nullable();
            $table->string('status')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('adminusers');
    }
};
