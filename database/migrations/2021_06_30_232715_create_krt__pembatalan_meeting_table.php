<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtPembatalanMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__pembatalan_meeting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_pembatalan_id')->unsigned();
            $table->bigInteger('minit_mesyuarat_id')->unsigned();
            $table->longText('keterangan')->nullable();
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
        Schema::dropIfExists('krt__pembatalan_meeting');
    }
}
