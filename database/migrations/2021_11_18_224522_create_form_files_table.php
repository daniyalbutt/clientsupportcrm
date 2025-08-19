<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_files', function (Blueprint $table) {
            $table->id();
            $table->string('path')->nullable();
            $table->string('name')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->unsignedBigInteger('logo_form_id')->nullable();
            $table->tinyInteger('form_code')->default('1');
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
        Schema::dropIfExists('form_files');
    }
}
