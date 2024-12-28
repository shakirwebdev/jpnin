<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtAktivitiPerancanganPenyertaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__aktiviti_perancangan_penyertaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('aktiviti_perancangan_id')->unsigned();
            $table->bigInteger('kaum_id')->unsigned();
            $table->bigInteger('jantina_id')->unsigned();
            $table->bigInteger('umur_id')->unsigned();
            $table->string('penyertaan_jumlah')->nullable();
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
        Schema::dropIfExists('krt__aktiviti_perancangan_penyertaan');
    }
}
