<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtJenisRumahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__jenis_rumah', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profileID')->unsigned();
            $table->bigInteger('jenis_rumah_id')->unsigned();
            $table->char('jumlah_pintu', 3);
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
        Schema::dropIfExists('krt__jenis_rumah');
    }
}
