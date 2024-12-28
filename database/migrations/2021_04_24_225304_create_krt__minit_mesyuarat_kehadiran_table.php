<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtMinitMesyuaratKehadiranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__minit_mesyuarat_kehadiran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_minit_mesyuarat_id')->unsigned();
            $table->string('kehadiran_nama');
            $table->string('kehadiran_ic');
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
        Schema::dropIfExists('krt__minit_mesyuarat_kehadiran');
    }
}
