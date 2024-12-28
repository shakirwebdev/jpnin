<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtProfileTable extends Migration
{
    public function up()
    {
        Schema::create('krt__profile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rt_applicationID')->unsigned();  
            $table->string('krt_nama');
            $table->longText('krt_alamat');
            $table->char('state_id', 2);
            $table->char('daerah_id', 4);
            $table->char('parlimen_id', 4)->nullable();
            $table->char('dun_id', 6)->nullable();
            $table->char('pbt_id', 6)->nullable();
            $table->string('krt_kawasan')->nullable();
            $table->string('krt_keluasan')->nullable();
            $table->string('krt_ipd')->nullable();
            $table->string('krt_balai')->nullable();
            $table->string('srs_nama')->nullable();
            $table->string('krt_tabika')->nullable();
            $table->string('krt_taska')->nullable();
            $table->bigInteger('krt_status_bagunan_id')->nullable()->unsigned();
            $table->bigInteger('krt_status')->unsigned();
            $table->bigInteger('dihantar_by')->nullable()->unsigned();
            $table->dateTime('dihantar_date')->nullable();
            $table->bigInteger('disemak_by')->nullable()->unsigned();
            $table->longText('disemak_note')->nullable();
            $table->dateTime('disemak_date')->nullable();
            $table->bigInteger('disahkan_by')->nullable()->unsigned();
            $table->longText('disahkan_note')->nullable();
            $table->dateTime('disahkan_date')->nullable();
            $table->bigInteger('diluluskan_by')->nullable()->unsigned();
            $table->longText('diluluskan_note')->nullable();
            $table->dateTime('diluluskan_date')->nullable();
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
        Schema::dropIfExists('krt__profile');
    }
}
