<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtBagunanSewaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__bagunan_sewa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profileID')->unsigned();
            $table->bigInteger('jenis_premis_id')->unsigned();
            $table->string('sewa_alamat');
            $table->char('sewa_pengguna_rt', 1)->nullable();
            $table->char('sewa_pengguna_srs', 1)->nullable();
            $table->char('sewa_pengguna_tabika', 1)->nullable();
            $table->char('sewa_pengguna_taska', 1)->nullable();
            $table->string('sewa_isu');
            $table->string('sewa_bayaran');
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
        Schema::dropIfExists('krt__bagunan_sewa');
    }
}
