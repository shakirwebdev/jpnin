<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrsAhliPerondaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srs__ahli_peronda', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->bigInteger('srs_profile_id')->unsigned()->nullable();
            $table->string('file_gambar_profile')->nullable();
            $table->string('peronda_nama')->nullable();
            $table->string('peronda_ic')->nullable();
            $table->date('peronda_tarikh_lahir')->nullable();
            $table->bigInteger('peronda_kaum')->nullable();
            $table->tinyInteger('peronda_jantina')->nullable();
            $table->string('peronda_warganegara')->nullable();
            $table->string('peronda_phone')->nullable();
            $table->longText('peronda_alamat')->nullable();
            $table->string('peronda_poskod')->nullable();
            $table->date('peronda_tarikh_lantikan')->nullable();
            $table->tinyInteger('peronda_status');
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
        Schema::dropIfExists('srs__ahli_peronda');
    }
}
