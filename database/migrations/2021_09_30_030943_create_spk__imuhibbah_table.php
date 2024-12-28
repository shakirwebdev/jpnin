<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpkImuhibbahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk__imuhibbah', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('hasRT', 1)->nullable();
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->string('imuhibbah_tajuk')->nullable();
            $table->char('state_id', 2)->nullable();
            $table->char('daerah_id', 4)->nullable();
            $table->bigInteger('bandar_id')->unsigned()->nullable();
            $table->string('imuhibbah_kawasan')->nullable();
            $table->string('imuhibbah_lokasi')->nullable();
            $table->string('imuhibbah_poskod')->nullable();
            $table->char('parlimen_id', 4)->nullable();
            $table->char('dun_id', 6)->nullable();
            $table->char('pbt_id', 6)->nullable();
            $table->date('imuhibbah_tarikh_laporan')->nullable();
            $table->date('imuhibbah_tarikh_j_berlaku')->nullable();
            $table->longText('imuhibbah_laporan')->nullable();
            $table->longText('imuhibbah_sumber_maklumat')->nullable();
            $table->string('imuhibbah_pelapor_nama')->nullable();
            $table->string('imuhibbah_pelapor_no')->nullable();
            $table->string('imuhibbah_pelapor_jawatan')->nullable();
            $table->string('imuhibbah_pelapor_alamat')->nullable();
            $table->bigInteger('status')->unsigned();
            $table->bigInteger('dihantar_by')->nullable()->unsigned();
            $table->dateTime('dihantar_date')->nullable();
            $table->bigInteger('diakui_by')->nullable()->unsigned();
            $table->longText('diakui_note')->nullable();
            $table->dateTime('diakui_date')->nullable();
            $table->bigInteger('disemak_by')->nullable()->unsigned();
            $table->longText('disemak_note')->nullable();
            $table->dateTime('disemak_date')->nullable();
            $table->bigInteger('disahkan_by')->nullable()->unsigned();
            $table->longText('disahkan_note')->nullable();
            $table->dateTime('disahkan_date')->nullable();
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
        Schema::dropIfExists('spk__imuhibbah');
    }
}
