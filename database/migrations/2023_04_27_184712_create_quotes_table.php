<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_no', 50)->nullable();
            $table->string('token', 50)->nullable();
            $table->string('reference', 50)->nullable();
            $table->integer('cust_id')->nullable();
            $table->integer('order_type')->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->string('email', 50)->nullable();
//            $table->text('property_address')->nullable();
            $table->text('address')->nullable();
            $table->string('apt_no', 255)->nullable();
            $table->string('zipcode', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 50)->nullable();
            $table->integer('billing_option')->default(0);
            $table->text('billing_address')->nullable();
            $table->string('billing_apt_no', 50)->nullable();
            $table->string('billing_zipcode', 50)->nullable();
            $table->string('billing_city', 50)->nullable();
            $table->string('billing_state', 50)->nullable();
            $table->string('relation', 50)->nullable();
            $table->string('reference_from', 50)->nullable();
            $table->string('referral', 50)->nullable();
            $table->string('referral_agency', 50)->nullable();
            $table->string('is_enquired', 50)->nullable();
            $table->string('currency_type', 50)->nullable();
            $table->text('notes')->nullable();
            $table->integer('status')->nullable();
            $table->integer('action_type')->nullable();
            $table->integer('action_by')->nullable();
            $table->integer('action_at')->nullable();
            $table->text('action_note')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('quotes');
    }
};
