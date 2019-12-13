<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrPurchaseOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_purchase_order', function (Blueprint $table) {
            $table->string('po_number');
            $table->date('date');
            $table->integer('vendor_id');
            $table->string('created_on');
            $table->string('created_by');
            $table->string('updated_on');
            $table->string('updated_by');
            $table->string('deleted_on');
            $table->string('deleted_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tr_purchase_order', function (Blueprint $table) {
            //
        });
    }
}
