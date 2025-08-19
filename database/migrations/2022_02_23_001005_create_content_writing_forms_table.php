<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentWritingFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_writing_forms', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('company_details')->nullable();
            $table->string('company_industry')->nullable();
            $table->string('company_reason')->nullable();
            $table->text('company_products')->nullable();
            $table->text('short_description')->nullable();
            $table->text('keywords')->nullable();
            $table->text('competitor')->nullable();
            $table->text('company_business')->nullable();
            $table->text('customers_accomplish')->nullable();
            $table->text('company_sets')->nullable();
            $table->text('mission_statement')->nullable();
            $table->text('existing_taglines')->nullable();
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
        Schema::dropIfExists('content_writing_forms');
    }
}
