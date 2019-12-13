<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tr_item', function (Blueprint $table) {
            $table->string('nama');
            $table->integer('stok');
            $table->integer('purchase_order_id');
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
        Schema::table('tr_item', function (Blueprint $table) {
            //
        });
    }
}
