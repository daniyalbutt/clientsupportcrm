<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogoFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logo_forms', function (Blueprint $table) {
            $table->id();
            $table->string('logo_name');
            $table->string('slogan')->nullable();
            $table->text('business');
            $table->text('logo_categories');
            $table->text('icon_based_logo');
            $table->string('font_style');
            $table->text('additional_information')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('logo_forms');
    }
}
