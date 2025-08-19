<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlatformsToSmmFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('smm_forms', function (Blueprint $table) {
            $table->text('facebook_page')->nullable();
            $table->text('instagram_page')->nullable();
            $table->text('instagram_password')->nullable();
            $table->text('twitter_page')->nullable();
            $table->text('twitter_password')->nullable();
            $table->text('linkedin_page')->nullable();
            $table->text('pinterest_page')->nullable();
            $table->text('pinterest_password')->nullable();
            $table->text('youtube_page')->nullable();
            $table->text('gmail_address_youtube')->nullable();
            $table->text('gmail_password_youtube')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('smm_forms', function (Blueprint $table) {
            $table->dropColumn('facebook_page');
            $table->dropColumn('instagram_page');
            $table->dropColumn('instagram_password');
            $table->dropColumn('twitter_page');
            $table->dropColumn('twitter_password');
            $table->dropColumn('linkedin_page');
            $table->dropColumn('pinterest_page');
            $table->dropColumn('pinterest_password');
            $table->dropColumn('youtube_page');
            $table->dropColumn('gmail_address_youtube');
            $table->dropColumn('gmail_password_youtube');
        });
    }
}
