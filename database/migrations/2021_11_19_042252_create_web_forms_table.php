<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_forms', function (Blueprint $table) {
            $table->id();
            $table->string('business_name')->nullable();
            $table->string('website_address')->nullable();
            $table->text('address')->nullable();
            $table->text('decision_makers')->nullable();
            $table->text('about_company')->nullable();
            $table->text('purpose')->nullable();
            $table->text('deadline')->nullable();
            $table->text('potential_clients')->nullable();
            $table->text('competitor')->nullable();
            $table->text('user_perform')->nullable();
            $table->text('pages')->nullable();
            $table->string('written_content')->nullable();
            $table->tinyInteger('copywriting_photography_services')->default('0');
            $table->tinyInteger('cms_site')->default('0');
            $table->tinyInteger('re_design')->default('0');
            $table->tinyInteger('working_current_site')->default('0');
            $table->string('going_to_need')->nullable();
            $table->text('additional_features')->nullable();
            $table->text('feel_about_company')->nullable();
            $table->text('incorporated')->nullable();
            $table->text('need_designed')->nullable();
            $table->text('specific_look')->nullable();
            $table->text('competition')->nullable();
            $table->text('websites_link')->nullable();
            $table->text('people_find_business')->nullable();
            $table->text('market_site')->nullable();
            $table->text('accounts_setup')->nullable();
            $table->text('links_accounts_setup')->nullable();
            $table->text('service_account')->nullable();
            $table->text('use_advertising')->nullable();
            $table->text('printed_materials')->nullable();
            $table->text('domain_name')->nullable();
            $table->text('hosting_account')->nullable();
            $table->text('login_ip')->nullable();
            $table->text('domain_like_name')->nullable();
            $table->string('section_regular_updating')->nullable();
            $table->string('updating_yourself')->nullable();
            $table->text('blog_written')->nullable();
            $table->string('regular_basis')->nullable();
            $table->text('fugure_pages')->nullable();
            $table->text('additional_information')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices');
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
        Schema::dropIfExists('web_forms');
    }
}
