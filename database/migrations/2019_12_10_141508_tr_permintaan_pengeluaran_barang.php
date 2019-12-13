<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrPermintaanPengeluaranBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_permintaan_pengeluaran_barang', function (Blueprint $table) {
            $table->string('no_surat');
            $table->integer('departemen_id');
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
        Schema::table('tr_permintaan_pengeluaran_barang', function (Blueprint $table) {
            //
        });
    }
}
