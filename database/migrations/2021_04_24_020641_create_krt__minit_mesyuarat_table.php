<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtMinitMesyuaratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__minit_mesyuarat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->string('mesyuarat_title')->nullable();
            $table->string('mesyuarat_bil')->nullable();
            $table->date('mesyuarat_tarikh')->nullable();
            $table->time('mesyuarat_time')->nullable();
            $table->string('mesyuarat_tempat')->nullable();
            $table->longText('mesyuarat_perutusan_pengerusi')->nullable();
            $table->longText('mesyuarat_yang_lalu')->nullable();
            $table->longText('mesyuarat_penyata_kewangan')->nullable();
            $table->longText('mesyuarat_penutup')->nullable();
            $table->bigInteger('mesyuarat_disedia')->unsigned()->nullable();
            $table->bigInteger('mesyuarat_disemak')->unsigned()->nullable();
            $table->boolean('mesyuarat_status')->nullable();
            $table->bigInteger('direkod_by')->unsigned()->nullable();
            $table->dateTime('direkod_date')->nullable();
            $table->bigInteger('disemak_by')->unsigned()->nullable();
            $table->dateTime('disemak_date')->nullable();
            $table->longText('disemak_note')->nullable();
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
        Schema::dropIfExists('krt__minit_mesyuarat');
    }
}
