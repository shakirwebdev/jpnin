<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbkStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbk__student', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tabika_id')->unsigned()->nullable();
            $table->string('student_nama')->nullable();
            $table->string('student_mykid')->nullable();
            $table->string('student_sijil_lahir')->nullable();
            $table->date('student_tarikh_lahir')->nullable();
            $table->bigInteger('student_agama_id')->unsigned()->nullable();
            $table->bigInteger('student_jantina_id')->unsigned()->nullable();
            $table->bigInteger('student_kaum_id')->unsigned()->nullable();
            $table->string('student_kesihatan')->nullable();
            $table->longText('student_alamat')->nullable();
            $table->string('student_jarak_rumah')->nullable();
            $table->string('bapa_nama')->nullable();
            $table->string('bapa_ic')->nullable();
            $table->string('bapa_pekerjaan')->nullable();
            $table->bigInteger('bapa_profession_id')->unsigned()->nullable();
            $table->string('bapa_pendapatan')->nullable();
            $table->longText('bapa_alamat_office')->nullable();
            $table->string('bapa_phone_office')->nullable();
            $table->bigInteger('bapa_kerakyatan_id')->unsigned()->nullable();
            $table->string('bapa_phone')->nullable();
            $table->string('bapa_jumlah_pendapatan')->nullable();
            $table->string('bapa_phone_rumah')->nullable();
            $table->string('ibu_nama')->nullable();
            $table->string('ibu_ic')->nullable();
            $table->string('ibu_pekerjaan')->nullable();
            $table->bigInteger('ibu_profession_id')->unsigned()->nullable();
            $table->string('ibu_pendapatan')->nullable();
            $table->longText('ibu_alamat_office')->nullable();
            $table->string('ibu_phone_office')->nullable();
            $table->bigInteger('ibu_kerakyatan_id')->unsigned()->nullable();
            $table->string('ibu_phone')->nullable();
            $table->string('ibu_jumlah_pendapatan')->nullable();
            $table->string('ibu_jumlah_pendapatan_lain')->nullable();
            $table->string('ibu_phone_rumah')->nullable();
            $table->string('ibu_bil_anak')->nullable();
            $table->string('ibu_bil_anak_sekolah')->nullable();
            $table->string('ibu_hubungan_student')->nullable();
            $table->string('ibu_tabika_lain')->nullable();
            $table->string('ibu_pilihan')->nullable();
            $table->string('student_status');
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
        Schema::dropIfExists('tbk__student');
    }
}
