<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtBagunanTumpangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__bagunan_tumpang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profileID')->unsigned();
            $table->bigInteger('tumpang_jenis_premis_id')->unsigned();
            $table->string('tumpang_alamat');
            $table->char('tumpang_pengguna_rt', 1)->nullable();
            $table->char('tumpang_pengguna_srs', 1)->nullable();
            $table->char('tumpang_pengguna_tabika', 1)->nullable();
            $table->char('tumpang_pengguna_taska', 1)->nullable();
            $table->char('tumpang_status_tanah_id', 1)->nullable();
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
        Schema::dropIfExists('krt__bagunan_tumpang');
    }
}
