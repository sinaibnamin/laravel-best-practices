<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up()
    {
        Schema::create('instructions', function (Blueprint $table) {
            $table->id();

            // Foreign key referencing 'id' in the 'members' table
            $table->integer('member_id')->nullable();

            $table->integer('trainer_id')->nullable();

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

 
    public function down()
    {
        Schema::dropIfExists('instructions');
    }
};
