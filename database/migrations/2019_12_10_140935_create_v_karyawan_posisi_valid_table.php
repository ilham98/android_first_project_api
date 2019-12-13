<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVKaryawanPosisiValidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v_karyawan_posisi_valid', function (Blueprint $table) {
            $table->string('npk');
            $table->string('nama');
            $table->date('valid_from');
            $table->date('valid_to');
            $table->string('position_id');
            $table->date('hierarchy_code');
            $table->string('kode_unit_kerja');
            $table->string('unit_kerja');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('v_karyawan_posisi_valid', function (Blueprint $table) {
            //
        });
    }
}
