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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('quote_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->integer('po_no')->nullable();
            $table->string('gst_no')->nullable();
            $table->double('freight')->nullable();
            $table->double('type')->nullable()->default(0);
            $table->double('id_invoice')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
