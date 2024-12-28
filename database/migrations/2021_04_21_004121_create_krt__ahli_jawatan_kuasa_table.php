<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtAhliJawatanKuasaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__ahli_jawatan_kuasa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->string('ajk_nama')->nullable();
            $table->string('ajk_ic')->nullable();
            $table->date('ajk_tarikh_lahir')->nullable();
            $table->bigInteger('ajk_kaum')->unsigned()->nullable();
            $table->bigInteger('ajk_jantina')->unsigned()->nullable();
            $table->string('ajk_warganegara')->nullable();
            $table->bigInteger('ajk_agama')->unsigned()->nullable();
            $table->string('ajk_phone')->nullable();
            $table->longText('ajk_alamat')->nullable();
            $table->string('ajk_poskod')->nullable();
            $table->bigInteger('ajk_profession_id')->unsigned()->nullable();
            $table->bigInteger('ajk_pendidikan_id')->unsigned()->nullable();
            $table->bigInteger('ajk_jawatan_krt_id')->unsigned()->nullable();
            $table->date('ajk_tarikh_mula')->nullable();
            $table->date('ajk_tarikh_akhir')->nullable();
            $table->char('ajk_bekepentingan', 1)->nullable();
            $table->char('ajk_bekepentingan_interaksi_1', 1)->nullable();
            $table->char('ajk_bekepentingan_interaksi_2', 1)->nullable();
            $table->char('ajk_bekepentingan_interaksi_3', 1)->nullable();
            $table->char('ajk_bekepentingan_interaksi_4', 1)->nullable();
            $table->char('ajk_bekepentingan_interaksi_5', 1)->nullable();
            $table->longText('ajk_berkepentingan_keterangan')->nullable();
            $table->bigInteger('ajk_status')->unsigned()->nullable();
            $table->bigInteger('ajk_status_form')->unsigned();
            $table->string('file_avatar')->nullable();
            $table->bigInteger('direkodby_user_id')->nullable()->unsigned();
            $table->dateTime('direkod_date')->nullable();
            $table->bigInteger('disahkan_by')->unsigned()->nullable();
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
        Schema::dropIfExists('krt__ahli_jawatan_kuasa');
    }
}
