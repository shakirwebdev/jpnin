<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtProfileSejiwaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__profile_sejiwa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->string('sejiwa_nama')->nullable();
            $table->date('sejiwa_tarikh_ditubuhkan')->nullable();
            $table->string('sejiwa_pusat_operasi')->nullable();
            $table->string('sejiwa_nama_pengerusi')->nullable();
            $table->string('sejiwa_ic_pengerusi')->nullable();
            $table->string('sejiwa_phone_pengerusi')->nullable();
            $table->string('sejiwa_email_pengerusi')->nullable();
            $table->string('sejiwa_alamat_pengerusi')->nullable();
            $table->string('sejiwa_pekerjaan_pengerusi')->nullable();
            $table->string('sejiwa_nama_timbalan')->nullable();
            $table->string('sejiwa_ic_timbalan')->nullable();
            $table->string('sejiwa_phone_timbalan')->nullable();
            $table->string('sejiwa_email_timbalan')->nullable();
            $table->string('sejiwa_alamat_timbalan')->nullable();
            $table->string('sejiwa_pekerjaan_timbalan')->nullable();
            $table->string('sejiwa_nama_su')->nullable();
            $table->string('sejiwa_ic_su')->nullable();
            $table->string('sejiwa_phone_su')->nullable();
            $table->string('sejiwa_email_su')->nullable();
            $table->string('sejiwa_alamat_su')->nullable();
            $table->string('sejiwa_pekerjaan_su')->nullable();
            $table->string('sejiwa_pegawai_nama')->nullable();
            $table->string('sejiwa_pegawai_jawatan')->nullable();
            $table->string('sejiwa_pegawai_phone')->nullable();
            $table->string('sejiwa_pegawai_emel')->nullable();
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
        Schema::dropIfExists('krt__profile_sejiwa');
    }
}
