<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtKoperasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__koperasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->string('koperasi_nama')->nullable();
            $table->dateTime('koperasi_tarikh_daftar')->nullable();
            $table->string('koperasi_bilangan_ahli_lembaga')->nullable();
            $table->string('koperasi_jumlah_anggota')->nullable();
            $table->bigInteger('status_koperasi_id')->unsigned()->nullable();
            $table->string('koperasi_pendapatan_semasa')->nullable();
            $table->string('koperasi_pendapatan_sebelum')->nullable();
            $table->bigInteger('status')->unsigned()->nullable();
            $table->bigInteger('dihantar_by')->nullable()->unsigned();
            $table->dateTime('dihantar_date')->nullable();
            $table->bigInteger('disemak_by')->nullable()->unsigned();
            $table->dateTime('disemak_date')->nullable();
            $table->longText('disemak_note')->nullable();
            $table->bigInteger('disahkan_by')->nullable()->unsigned();
            $table->dateTime('disahkan_date')->nullable();
            $table->longText('disahkan_note')->nullable();
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
        Schema::dropIfExists('krt__koperasi');
    }
}
