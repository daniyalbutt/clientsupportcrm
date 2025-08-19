<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProofreadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proofreadings', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->text('word_count')->nullable();
            $table->text('services')->nullable();
            $table->text('completion')->nullable();
            $table->text('previously')->nullable();
            $table->text('specific_areas')->nullable();
            $table->text('suggestions')->nullable();
            $table->text('mention')->nullable();
            $table->text('major')->nullable();
            $table->text('trigger')->nullable();
            $table->text('character')->nullable();
            $table->text('guide')->nullable();
            $table->text('areas')->nullable();
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
        Schema::dropIfExists('proofreadings');
    }
}
