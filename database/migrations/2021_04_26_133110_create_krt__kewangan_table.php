<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtKewanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__kewangan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->string('kewangan_no_acc')->nullable();
            $table->string('kewangan_nama_bank')->nullable();
            $table->string('kewangan_no_evendor')->nullable();
            $table->tinyInteger('kewangan_jenis_kewangan')->unsigned()->nullable();
            $table->string('kewangan_nama_penuh')->nullable();
            $table->string('kewangan_alamat')->nullable();
            $table->string('kewangan_butiran')->nullable();
            $table->date('kewangan_tarikh_t_b')->nullable();
            $table->string('kewangan_cek_baucer')->nullable();
            $table->string('kewangan_tarikh_cek')->nullable();
            $table->string('kewangan_jumlah_tunai')->nullable()->default('0');
            $table->string('kewangan_jumlah_bank')->nullable()->default('0');
            $table->string('kewangan_baki_tunai')->nullable()->default('0');
            $table->string('kewangan_baki_bank')->nullable()->default('0');
            $table->string('kewangan_jumlah_baki')->nullable()->default('0');
            $table->tinyInteger('kewangan_status')->unsigned()->nullable();
            $table->bigInteger('direkodby')->unsigned()->nullable();
            $table->dateTime('rekod_date')->nullable();
            $table->bigInteger('semakby')->unsigned()->nullable();
            $table->dateTime('semak_date')->nullable();
            $table->longText('semak_noted')->nullable();
            $table->bigInteger('sahby')->unsigned()->nullable();
            $table->dateTime('sah_date')->nullable();
            $table->longText('sah_noted')->nullable();
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
        Schema::dropIfExists('krt__kewangan');
    }
}
