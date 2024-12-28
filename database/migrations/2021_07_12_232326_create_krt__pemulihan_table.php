<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtPemulihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__pemulihan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->string('pemulihan_tempoh_bulan')->nullable();
            $table->string('pemulihan_punca_tidak_aktif')->nullable();
            $table->string('pemulihan_suku_thn_1')->nullable();
            $table->string('pemulihan_suku_thn_2')->nullable();
            $table->string('pemulihan_suku_thn_3')->nullable();
            $table->string('pemulihan_suku_thn_4')->nullable();
            $table->string('pemulihan_tempoh_pelaksanaan')->nullable();
            $table->string('pemulihan_cadangan_ppd')->nullable();
            $table->string('pemulihan_cadangan_hq')->nullable();
            $table->string('pemulihan_markah')->nullable();
            $table->bigInteger('status')->unsigned()->nullable();
            $table->bigInteger('dihantar_by')->nullable()->unsigned();
            $table->dateTime('dihantar_date')->nullable();
            $table->bigInteger('disemak_by')->nullable()->unsigned();
            $table->dateTime('disemak_date')->nullable();
            $table->longText('disemak_note')->nullable();
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
        Schema::dropIfExists('krt__pemulihan');
    }
}
