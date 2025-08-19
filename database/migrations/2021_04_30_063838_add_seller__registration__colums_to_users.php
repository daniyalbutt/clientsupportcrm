<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSellerRegistrationColumsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('res_add')->nullable();;
            $table->string('res_add_lat')->nullable();;
            $table->string('res_add_log')->nullable();;
            $table->string('work_add')->nullable();;
            $table->string('work_add_lat')->nullable();;
            $table->string('work_add_log')->nullable();;
            $table->string('city')->nullable();;
            $table->string('work_cont')->nullable();;
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('res_add');
            $table->dropColumn('res_add_lat');
            $table->dropColumn('res_add_log');
            $table->dropColumn('work_add');
            $table->dropColumn('work_add_lat');
            $table->dropColumn('work_add_log');
            $table->dropColumn('city');
            $table->dropColumn('work_cont ');
        });
    }
}
