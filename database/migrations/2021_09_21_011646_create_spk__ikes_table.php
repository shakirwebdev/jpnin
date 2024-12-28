<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpkIkesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk__ikes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('hasRT', 1)->nullable();
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->char('state_id', 2)->nullable();
            $table->char('daerah_id', 4)->nullable();
            $table->bigInteger('bandar_id')->unsigned()->nullable();
            $table->string('ikes_kawasan')->nullable();
            $table->string('ikes_lokasi')->nullable();
            $table->string('ikes_poskod')->nullable();
            $table->char('parlimen_id', 4)->nullable();
            $table->char('dun_id', 6)->nullable();
            $table->char('pbt_id', 6)->nullable();
            $table->string('ikes_bpolis')->nullable();
            $table->date('ikes_tarikh_berlaku')->nullable();
            $table->bigInteger('peringkat_id')->unsigned()->nullable();
            $table->bigInteger('kategori_id')->unsigned()->nullable();
            $table->longText('ikes_keterangan_kes')->nullable();
            $table->longText('ikes_tindakan_awal')->nullable();
            $table->string('ikes_sumber')->nullable();
            $table->string('ikes_bil_terlibat')->nullable();
            $table->bigInteger('status_warganegara_id')->unsigned()->nullable();
            $table->bigInteger('status_etnik_id')->unsigned()->nullable();
            $table->string('ikes_bil_tangkapan')->nullable();
            $table->char('hasTindakan', 1)->nullable();
            $table->string('ikes_keterangan_tindakan')->nullable();
            $table->string('ikes_keadaan_semasa')->nullable();
            $table->longText('ikes_jangkaan_keadaan')->nullable();
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
        Schema::dropIfExists('spk__ikes');
    }
}
