<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrsPermohonanPembatalanMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srs__permohonan_pembatalan_meeting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pembatalan_srs_id')->unsigned();
            $table->string('minit_mesyuarat_id');
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
        Schema::dropIfExists('srs__permohonan_pembatalan_meeting');
    }
}
