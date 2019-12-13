<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsVendorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_vendor', function (Blueprint $table) {
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
        Schema::table('ms_vendor', function (Blueprint $table) {
            //
        });
    }
}
