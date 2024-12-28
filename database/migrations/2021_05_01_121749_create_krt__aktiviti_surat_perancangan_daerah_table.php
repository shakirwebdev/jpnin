<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtAktivitiSuratPerancanganDaerahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__aktiviti_surat_perancangan_daerah', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('daerah_id', 4)->nullable();
            $table->bigInteger('krt_id')->unsigned();
            $table->string('surat_tahun_perancangan');
            $table->date('surat_tarikh');
            $table->bigInteger('created_by')->unsigned();
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
        Schema::dropIfExists('krt__aktiviti_surat_perancangan_daerah');
    }
}
