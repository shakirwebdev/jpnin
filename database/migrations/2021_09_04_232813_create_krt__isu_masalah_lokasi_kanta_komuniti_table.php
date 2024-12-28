<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtIsuMasalahLokasiKantaKomunitiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__isu_masalah_lokasi_kanta_komuniti', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->string('isu_lokasi_kanta_komuniti')->nullable();
            $table->string('isu_kluster')->nullable();
            $table->string('isu_bil_terlibat')->nullable();
            $table->longText('isu_pelaksanan_daerah')->nullable();
            $table->longText('isu_pelaksanan_negeri')->nullable();
            $table->string('isu_agensi_terlibat')->nullable();
            $table->bigInteger('isu_status')->unsigned()->nullable();
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
        Schema::dropIfExists('krt__isu_masalah_lokasi_kanta_komuniti');
    }
}
