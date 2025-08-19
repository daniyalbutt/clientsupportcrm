<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookFormattingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_formattings', function (Blueprint $table) {
            $table->id();
            $table->string('book_title')->nullable();
            $table->string('book_subtitle')->nullable();
            $table->string('author_name')->nullable();
            $table->string('contributors')->nullable();
            $table->text('publish_your_book')->nullable();
            $table->text('book_formatted')->nullable();
            $table->string('trim_size')->nullable();
            $table->string('other_trim_size')->nullable();
            $table->text('additional_instructions')->nullable();
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
        Schema::dropIfExists('book_formattings');
    }
}
