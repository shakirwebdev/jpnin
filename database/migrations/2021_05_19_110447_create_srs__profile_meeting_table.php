<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrsProfileMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srs__profile_meeting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('srs_profile_id')->unsigned();
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
        Schema::dropIfExists('srs__profile_meeting');
    }
}
