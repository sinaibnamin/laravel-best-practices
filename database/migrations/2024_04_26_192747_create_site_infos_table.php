<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('site_infos', function (Blueprint $table) {
            $table->id();


            $table->text('site_title')->nullable();
            $table->text('site_description')->nullable();

            $table->text('site_headline_en')->nullable();
            $table->text('site_headline_bn')->nullable();
            $table->text('site_subheadline_en')->nullable();
            $table->text('site_subheadline_bn')->nullable();
            $table->text('site_footnote_en')->nullable();
            $table->text('site_footnote_bn')->nullable();

            $table->text('site_facebook')->nullable();
            $table->text('site_twitter')->nullable();
            $table->text('site_instagram')->nullable();
            $table->text('site_linkedin')->nullable();


           $table->text('site_logo')->nullable();
           $table->text('site_home_bg_img')->nullable();


            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('site_infos');
    }
};
