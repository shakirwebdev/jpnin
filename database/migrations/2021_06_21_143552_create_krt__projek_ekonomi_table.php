<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtProjekEkonomiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__projek_ekonomi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->string('projek_nama')->nullable();
            $table->longText('projek_penerangan')->nullable();
            $table->bigInteger('status_pelaksanaan_projek_id')->unsigned()->nullable();
            $table->bigInteger('sekala_project_semasa_id')->unsigned()->nullable();
            $table->bigInteger('sekala_project_hadapan_id')->unsigned()->nullable();
            $table->longText('projek_jaringan')->nullable();
            $table->string('projek_tahun')->nullable();
            $table->string('projek_impak')->nullable();
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
        Schema::dropIfExists('krt__projek_ekonomi');
    }
}
