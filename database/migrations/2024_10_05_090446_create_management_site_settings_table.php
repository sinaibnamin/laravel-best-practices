<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up()
    {
        Schema::create('management_site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_name')->nullable();
            $table->string('system_icon')->nullable();
            $table->string('system_logo')->nullable();
            $table->longText('routine')->nullable();
            $table->longText('print_header')->nullable();
            $table->string('sms_alert_enable')->nullable();
            $table->string('online_payment_enable')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('management_site_settings');
    }
};
