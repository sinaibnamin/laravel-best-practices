<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->date('date')->nullable();
            $table->string('pay_by')->nullable();
            $table->integer('member_id')->nullable();
            $table->integer('package_id')->nullable();
            $table->text('package_name')->nullable();
            $table->integer('package_price')->default(0);
            $table->integer('package_duration')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('paid')->default(0);
            $table->integer('due')->default(0);
            $table->date('validity')->nullable();
            $table->text('comments')->nullable();
            $table->string('status')->nullable();            

            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
