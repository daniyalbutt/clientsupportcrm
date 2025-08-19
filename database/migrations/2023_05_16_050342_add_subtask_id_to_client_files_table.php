<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubtaskIdToClientFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_files', function (Blueprint $table) {
            $table->unsignedBigInteger('subtask_id')->nullable();
            $table->foreign('subtask_id')->references('id')->on('sub_task');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_files', function (Blueprint $table) {
            $table->dropColumn('subtask_id');
        });
    }
}
