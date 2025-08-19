<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignIdToSubTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_task', function (Blueprint $table) {
            $table->unsignedBigInteger('assign_id')->nullable();
            $table->foreign('assign_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_task', function (Blueprint $table) {
            $table->dropColumn('assign_id');
        });
    }
}
