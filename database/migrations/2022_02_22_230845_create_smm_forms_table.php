<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmmFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smm_forms', function (Blueprint $table) {
            $table->id();
            $table->string('desired_results')->nullable();
            $table->string('business_name')->nullable();
            $table->string('business_email_address')->nullable();
            $table->string('business_phone_number')->nullable();
            $table->string('business_mailing_address')->nullable();
            $table->string('business_location')->nullable();
            $table->string('business_website_address')->nullable();
            $table->string('business_working_hours')->nullable();
            $table->string('business_category')->nullable();
            $table->string('social_media_platforms')->nullable();
            $table->string('target_locations')->nullable();
            $table->string('target_audience')->nullable();
            $table->string('age_bracket')->nullable();
            $table->text('represent_your_business')->nullable();
            $table->text('business_usp')->nullable();
            $table->text('do_not_want_us_to_use')->nullable();
            $table->text('competitors')->nullable();
            $table->text('additional_comments')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices');
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
        Schema::dropIfExists('smm_forms');
    }
}
