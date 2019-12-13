<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TmpVendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_vendor', function (Blueprint $table) {
            $table->string('nama');
            $table->string('contact_person');
            $table->string('created_on');
            $table->string('created_by');
            $table->string('updated_on');
            $table->string('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tmp_vendor', function (Blueprint $table) {
            //
        });
    }
}
