<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtJenisPertubuhanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__jenis_pertubuhan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profileID')->unsigned();
            $table->bigInteger('jenis_pertubuhan_id')->unsigned();
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
        Schema::dropIfExists('krt__jenis_pertubuhan');
    }
}
