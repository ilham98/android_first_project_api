<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Aset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_aset', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('registration_number');
            $table->integer('purchase_order_id');
            $table->integer('item_id');
            $table->integer('tipe_id');
            $table->integer('status_id');
            $table->integer('permintaan_pengeluaran_barang_id');
            $table->integer('status_pengeluaran_barang_id');
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
        Schema::dropIfExists('tr_aset');
    }
}
