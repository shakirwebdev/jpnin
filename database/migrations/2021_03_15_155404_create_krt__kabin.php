<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtKabin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__kabin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profileID')->unsigned();
            $table->bigInteger('kabin_jenis')->unsigned();
            $table->string('kabin_sumbangan_lain')->nullable();
            $table->string('kabin_alamat');
            $table->char('kabin_status_tanah_id', 1)->nullable();
            $table->date('kabin_tarikh_bina');
            $table->string('kabin_kos');
            $table->char('kabin_pengguna_rt', 1)->nullable();
            $table->char('kabin_pengguna_srs', 1)->nullable();
            $table->char('kabin_pengguna_tabika', 1)->nullable();
            $table->char('kabin_pengguna_taska', 1)->nullable();
            $table->string('kabin_isu');
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
        Schema::dropIfExists('krt__kabin');
    }
}
