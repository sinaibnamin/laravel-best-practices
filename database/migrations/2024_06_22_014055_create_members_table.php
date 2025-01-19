<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('nid')->nullable();
           
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('username')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->text('medical_conditions_details')->nullable();
            $table->string('fitness_goals')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->nullable();
            $table->string('password')->nullable();

            $table->string('uniq_id')->nullable()->unique();
            $table->string('blood_group')->nullable();
            $table->string('profession')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('neck')->nullable();
            $table->string('shoulder')->nullable();
            $table->string('chest')->nullable();
            $table->string('abdomen')->nullable();
            $table->string('waist')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('package_id')->nullable();
            $table->date('validity')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('members');
    }
};
