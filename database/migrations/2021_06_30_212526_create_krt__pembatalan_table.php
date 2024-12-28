<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtPembatalanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__pembatalan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->bigInteger('tujuan_pembatalan_id')->unsigned()->nullable();
            $table->string('nyatakan_tujuan')->nullable();
            $table->bigInteger('status')->unsigned()->nullable();
            $table->bigInteger('direkod_by')->nullable()->unsigned();
            $table->dateTime('direkod_date')->nullable();
            $table->bigInteger('disemak_by')->nullable()->unsigned();
            $table->dateTime('disemak_date')->nullable();
            $table->longText('disemak_note')->nullable();
            $table->bigInteger('disokong_by')->nullable()->unsigned();
            $table->dateTime('disokong_date')->nullable();
            $table->longText('disokong_note')->nullable();
            $table->bigInteger('diluluskan_by')->nullable()->unsigned();
            $table->dateTime('diluluskan_date')->nullable();
            $table->longText('diluluskan_note')->nullable();
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
        Schema::dropIfExists('krt__pembatalan');
    }
}
