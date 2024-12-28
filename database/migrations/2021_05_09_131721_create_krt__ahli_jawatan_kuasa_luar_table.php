<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtAhliJawatanKuasaLuarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__ahli_jawatan_kuasa_luar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->string('ajk_luar_nama')->nullable();
            $table->string('ajk_luar_ic')->nullable();
            $table->longText('ajk_luar_alamat')->nullable();
            $table->char('ajk_luar_miliki_perniagaan', 1)->nullable();
            $table->char('ajk_luar_miliki_keluarga', 1)->nullable();
            $table->char('ajk_luar_miliki_pekerjaan', 1)->nullable();
            $table->char('ajk_luar_miliki_jawatan', 1)->nullable();
            $table->char('ajk_luar_miliki_kepentingan', 1)->nullable();
            $table->longText('ajk_luar_note')->nullable();
            $table->bigInteger('direkod_by')->nullable()->unsigned();
            $table->dateTime('direkod_date')->nullable();
            $table->bigInteger('disahkan_by')->unsigned()->nullable();
            $table->dateTime('disahkan_date')->nullable();
            $table->longText('disahkan_note')->nullable();
            $table->bigInteger('ajk_luar_status')->unsigned()->nullable();
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
        Schema::dropIfExists('krt__ahli_jawatan_kuasa_luar');
    }
}
