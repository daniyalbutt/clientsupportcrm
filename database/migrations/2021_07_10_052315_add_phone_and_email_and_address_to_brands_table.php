<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneAndEmailAndAddressToBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('phone_tel')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('address_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('phone_tel');
            $table->dropColumn('email');
            $table->dropColumn('address');
            $table->dropColumn('address_link');
        });
    }
}
