<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrsPermohonanPenarikanDiriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srs__permohonan_penarikan_diri', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->bigInteger('srs_profile_id')->unsigned()->nullable();
            $table->bigInteger('ahli_peronda_id')->unsigned()->nullable();
            $table->bigInteger('alasan_id')->unsigned()->nullable();
            $table->string('penarikan_diri_nyatakan')->nullable();
            $table->string('penarikan_diri_status')->nullable();
            $table->bigInteger('direkod_by')->nullable()->unsigned();
            $table->dateTime('direkod_date')->nullable();
            $table->bigInteger('disemak_by')->nullable()->unsigned();
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
        Schema::dropIfExists('srs__permohonan_penarikan_diri');
    }
}
