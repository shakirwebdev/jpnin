<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtAhliJawatanKuasaCawanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__ahli_jawatan_kuasa_cawangan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->bigInteger('cawangan_id')->unsigned()->nullable();
            $table->string('ajk_nama')->nullable();
            $table->string('ajk_ic')->nullable();
            $table->date('ajk_tarikh_lahir')->nullable();
            $table->bigInteger('jantina_id')->unsigned()->nullable();
            $table->bigInteger('kaum_id')->unsigned()->nullable();
            $table->longText('ajk_alamat')->nullable();
            $table->string('ajk_poskod')->nullable();
            $table->string('ajk_phone')->nullable();
            $table->string('ajk_email')->nullable();
            $table->bigInteger('status_perkahwinan_id')->unsigned()->nullable();
            $table->bigInteger('jawatan_cawangan_id')->unsigned()->nullable();
            $table->bigInteger('status_perkejaan_id')->unsigned()->nullable();
            $table->string('ajk_pekerjaan_jawatan')->nullable();
            $table->string('ajk_pekerjaan_bidang')->nullable();
            $table->longText('ajk_pekerjaan_pengalaman')->nullable();
            $table->longText('ajk_kemahiran')->nullable();
            $table->longText('ajk_minat')->nullable();
            $table->bigInteger('ajk_status')->unsigned()->nullable();
            $table->bigInteger('ajk_status_form')->unsigned();
            $table->bigInteger('direkod_by')->nullable()->unsigned();
            $table->dateTime('direkod_date')->nullable();
            $table->bigInteger('disemak_by')->unsigned()->nullable();
            $table->dateTime('disemak_date')->nullable();
            $table->longText('disemak_note')->nullable();
            $table->bigInteger('diakui_by')->unsigned()->nullable();
            $table->dateTime('diakui_date')->nullable();
            $table->longText('diakui_note')->nullable();
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
        Schema::dropIfExists('krt__ahli_jawatan_kuasa_cawangan');
    }
}
