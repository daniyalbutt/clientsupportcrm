<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookMarketingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_marketings', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('behind_title')->nullable();
            $table->text('key_message')->nullable();
            $table->text('giveaways')->nullable();
            $table->text('target_audience')->nullable();
            $table->text('launched')->nullable();
            $table->text('published_book')->nullable();
            $table->text('sold_book')->nullable();
            $table->text('marketing')->nullable();
            $table->text('author_name')->nullable();
            $table->text('social_pages')->nullable();
            $table->text('basics')->nullable();
            $table->text('selling_point')->nullable();
            $table->text('keywords')->nullable();
            $table->text('goals')->nullable();
            $table->text('book_stores')->nullable();
            $table->text('approach')->nullable();
            $table->text('motto')->nullable();
            $table->text('price_point')->nullable();
            $table->text('number_pages')->nullable();
            $table->text('paper_back')->nullable();
            $table->text('advantages')->nullable();
            $table->text('existing_website')->nullable();
            $table->text('call_action')->nullable();
            $table->text('web_pages')->nullable();
            $table->text('achieve_goals')->nullable();
            $table->text('competitors')->nullable();
            $table->text('relevant_information')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->foreign('agent_id')->references('id')->on('users');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients');
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
        Schema::dropIfExists('book_marketings');
    }
}
