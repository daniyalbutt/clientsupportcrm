<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_websites', function (Blueprint $table) {
            $table->id();
            $table->text('author_name')->nullable();
            $table->text('email_address')->nullable();
            $table->text('contact_number')->nullable();
            $table->text('address')->nullable();
            $table->text('postal_code')->nullable();
            $table->text('city')->nullable();
            $table->text('desired_domain')->nullable();
            $table->text('own_domain')->nullable();
            $table->text('login_ip')->nullable();
            $table->text('brief_overview')->nullable();
            $table->text('purpose')->nullable();
            $table->text('user_perform')->nullable();
            $table->text('user_perform_other')->nullable();
            $table->text('feel_website')->nullable();
            $table->tinyInteger('have_logo')->default('0');
            $table->tinyInteger('specific_look')->default('0');
            $table->text('competitor_website_link_1')->nullable();
            $table->text('competitor_website_link_2')->nullable();
            $table->text('competitor_website_link_3')->nullable();
            $table->text('pages_sections')->nullable();
            $table->tinyInteger('written_content')->default('0');
            $table->tinyInteger('need_copywriting')->default('0');
            $table->tinyInteger('cms_site')->default('0');
            $table->tinyInteger('existing_site')->default('0');
            $table->text('about_your_book')->nullable();
            $table->tinyInteger('social_networks')->default('0');
            $table->tinyInteger('social_linked')->default('0');
            $table->tinyInteger('social_marketing')->default('0');
            $table->tinyInteger('advertising_book')->default('0'); 
            $table->tinyInteger('regular_updating')->default('0');
            $table->tinyInteger('updating_yourself')->default('0');
            $table->tinyInteger('already_written')->default('0');
            $table->tinyInteger('features_pages')->default('0');
            $table->text('typical_homepage')->nullable();
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
        Schema::dropIfExists('author_websites');
    }
}
