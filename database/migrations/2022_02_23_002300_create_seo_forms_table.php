<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeoFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_forms', function (Blueprint $table) {
            $table->id();
            $table->string('business_established')->nullable();
            $table->string('original_owner')->nullable();
            $table->string('age_current_site')->nullable();
            $table->string('top_goals')->nullable();
            $table->string('core_offer')->nullable();
            $table->string('average_order_value')->nullable();
            $table->string('selling_per_month')->nullable();
            $table->string('client_lifetime_value')->nullable();
            $table->string('supplementary_offers')->nullable();
            $table->string('getting_clients')->nullable();
            $table->string('currently_spending')->nullable();
            $table->string('monthly_visitors')->nullable();
            $table->string('people_adding')->nullable();
            $table->string('monthly_financial')->nullable();
            $table->string('that_much')->nullable();
            $table->text('specific_target')->nullable();
            $table->string('competitors')->nullable();
            $table->string('third_party_marketing')->nullable();
            $table->string('current_monthly_sales')->nullable();
            $table->string('current_monthly_revenue')->nullable();
            $table->string('target_region')->nullable();
            $table->string('looking_to_execute')->nullable();
            $table->string('time_zone')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->foreign('agent_id')->references('id')->on('users');
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
        Schema::dropIfExists('seo_forms');
    }
}
