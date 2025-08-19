<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookWritingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_writings', function (Blueprint $table) {
            $table->id();
            $table->string('book_title')->nullable();
            $table->text('genre_book')->nullable();
            $table->text('brief_summary')->nullable();
            $table->text('purpose')->nullable();
            $table->text('target_audience')->nullable();
            $table->text('desired_length')->nullable();
            $table->text('specific_characters')->nullable();
            $table->text('specific_themes')->nullable();
            $table->text('writing_style')->nullable();
            $table->text('specific_tone')->nullable();
            $table->text('existing_materials')->nullable();
            $table->text('existing_books')->nullable();
            $table->string('specific_deadlines')->nullable();
            $table->text('specific_instructions')->nullable();
            $table->string('research')->nullable();
            $table->text('specific_chapter')->nullable();
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
        Schema::dropIfExists('book_writings');
    }
}
