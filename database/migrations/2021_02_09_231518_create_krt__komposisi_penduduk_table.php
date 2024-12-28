<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtKomposisiPendudukTable extends Migration
{
    public function up()
    {
        Schema::create('krt__komposisi_penduduk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profileID')->unsigned();
            $table->bigInteger('komposisi_kaum')->unsigned();
            $table->char('komposisi_jumlah', 4);
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
        Schema::dropIfExists('krt__komposisi_penduduk');
    }
}
