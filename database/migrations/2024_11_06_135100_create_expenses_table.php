<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->date('date')->nullable();
            $table->integer('expense_type_id')->nullable();
            $table->integer('amount')->nullable();
            $table->text('description')->nullable();
        
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
