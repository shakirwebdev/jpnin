<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbkProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbk__profile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_id')->unsigned()->nullable();
            $table->string('tbk_ref_no')->nullable();
            $table->string('tbk_nama')->nullable();
            $table->char('state_id', 2)->nullable();
            $table->char('daerah_id', 4)->nullable();
            $table->char('parlimen_id', 4)->nullable();
            $table->char('dun_id', 6)->nullable();
            $table->longText('tbk_alamat')->nullable();
            $table->string('tbk_poskod')->nullable();
            $table->string('tbk_kode_prd')->nullable();
            $table->string('tbk_status');
            $table->bigInteger('dihantar_by')->nullable()->unsigned();
            $table->dateTime('dihantar_date')->nullable();
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
        Schema::dropIfExists('tbk__profile');
    }
}
