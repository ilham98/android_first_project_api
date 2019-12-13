<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsUnitkerjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_unitkerja', function (Blueprint $table) {
            $table->string('KodeUnitKerja');
            $table->string('UnitKerja');
            $table->string('Keterangan');
            $table->string('IsAktif');
            $table->string('CreatedBy');
            $table->string('CreatedOn');
            $table->string('UpdatedBy');
            $table->string('UpdatedOn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ms_unitkerja', function (Blueprint $table) {
            //
        });
    }
}
