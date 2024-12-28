<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtAktivitiPerancanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__aktiviti_perancangan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->char('state_id', 2)->nullable();
            $table->char('daerah_id', 4)->nullable();
            $table->longText('aktiviti_tempat')->nullable();
            $table->longText('aktiviti_kawasan_DL')->nullable();
            $table->string('aktiviti_tajuk')->nullable();
            $table->date('aktiviti_tarikh')->nullable();
            $table->date('aktiviti_tarikh_rancang')->nullable();
            $table->time('aktiviti_masa')->nullable();
            $table->string('aktiviti_penganjur')->nullable();
            $table->bigInteger('bahagian_id')->unsigned()->nullable();
            $table->bigInteger('pmk_id')->unsigned()->nullable();
            $table->bigInteger('agenda_id')->unsigned()->nullable();
            $table->bigInteger('bidang_id')->unsigned()->nullable();
            $table->bigInteger('sub_bidang_id')->unsigned()->nullable();
            $table->bigInteger('teras_id')->unsigned()->nullable();
            $table->bigInteger('strategi_id')->unsigned()->nullable();
            $table->string('aktiviti_kategori_pemulihan')->nullable();
            $table->string('aktiviti_kategori_pencegahan')->nullable();
            $table->bigInteger('jenis_aktiviti_id')->unsigned()->nullable();
            $table->string('aktiviti_pembelanjaan')->nullable();
            $table->bigInteger('kewangan_id')->unsigned()->nullable();
            $table->string('aktiviti_sasar')->nullable();
            $table->string('aktiviti_perasmi')->nullable();
            $table->longText('aktiviti_ringkasan_program')->nullable();
            $table->char('aktiviti_post_mortem', 1)->nullable();
            $table->char('aktiviti_soal_selidik', 1)->nullable();
            $table->char('aktiviti_pemerhatian', 1)->nullable();
            $table->char('aktiviti_temubual', 1)->nullable();
            $table->longText('aktiviti_kekuatan')->nullable();
            $table->longText('aktiviti_keberkesanan')->nullable();
            $table->longText('aktiviti_penambahbaikan')->nullable();
            $table->bigInteger('aktiviti_status')->unsigned()->nullable();
            $table->bigInteger('dihantar_by')->nullable()->unsigned();
            $table->dateTime('dihantar_date')->nullable();
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
        Schema::dropIfExists('krt__aktiviti_perancangan');
    }
}
