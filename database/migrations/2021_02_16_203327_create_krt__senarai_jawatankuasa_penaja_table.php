<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtSenaraiJawatankuasaPenajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__senarai_jawatankuasa_penaja', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profileID')->unsigned();
            $table->string('penaja_nama',100);
            $table->string('penaja_ic',100);
            $table->date('penaja_birth');
            $table->bigInteger('ref_jantinaID')->unsigned();
            $table->bigInteger('ref_kaumID')->unsigned();
            $table->string('penaja_pekerjaan');
            $table->string('penaja_alamat_rumah');
            $table->string('penaja_no_fone');
            $table->string('penaja_alamat_pejabat')->nullable();
            $table->string('penaja_no_office')->nullable();
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
        Schema::dropIfExists('krt__senarai_jawatankuasa_penaja');
    }
}
