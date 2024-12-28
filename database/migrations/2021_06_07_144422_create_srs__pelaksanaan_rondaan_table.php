<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrsPelaksanaanRondaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srs__pelaksanaan_rondaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->bigInteger('srs_profile_id')->unsigned()->nullable();
            $table->date('pelaksanaan_rondaan_tarikh')->nullable();
            $table->string('pelaksanaan_rondaan_kes')->nullable();
            $table->bigInteger('kategori_kes_id')->unsigned()->nullable();
            $table->bigInteger('jenis_kes_id')->unsigned()->nullable();
            $table->longText('kes_keterangan')->nullable();
            $table->string('kes_jumlah_org_terlibat')->nullable();
            $table->bigInteger('kes_dirujuk_id')->unsigned()->nullable();
            $table->bigInteger('pelaksanaan_rondaan_status')->unsigned()->nullable();
            $table->bigInteger('direkod_by')->nullable()->unsigned();
            $table->dateTime('direkod_date')->nullable();
            $table->bigInteger('disahkan_by')->nullable()->unsigned();
            $table->dateTime('disahkan_date')->nullable();
            $table->longText('disahkan_note')->nullable();
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
        Schema::dropIfExists('srs__pelaksanaan_rondaan');
    }
}
