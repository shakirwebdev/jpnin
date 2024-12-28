<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtProfileSejiwaCabaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__profile_sejiwa_cabaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sejiwa_id')->unsigned();
            $table->string('cabaran_sejiwa_cabaran');
            $table->string('cabaran_sejiwa_mengatasi');
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
        Schema::dropIfExists('krt__profile_sejiwa_cabaran');
    }
}
