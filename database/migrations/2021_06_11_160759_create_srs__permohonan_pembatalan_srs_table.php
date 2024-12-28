<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrsPermohonanPembatalanSrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srs__permohonan_pembatalan_srs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->bigInteger('srs_profile_id')->unsigned()->nullable();
            $table->bigInteger('pembatalan_status')->unsigned()->nullable();
            $table->bigInteger('direkod_by')->nullable()->unsigned();
            $table->dateTime('direkod_date')->nullable();
            $table->bigInteger('disemak_by')->nullable()->unsigned();
            $table->dateTime('disemak_date')->nullable();
            $table->longText('disemak_note')->nullable();
            $table->bigInteger('disahkan_by')->nullable()->unsigned();
            $table->dateTime('disahkan_date')->nullable();
            $table->longText('disahkan_note')->nullable();
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
        Schema::dropIfExists('srs__permohonan_pembatalan_srs');
    }
}
