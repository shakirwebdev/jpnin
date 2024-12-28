<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtAktivitiSuratPerancanganNegeriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__aktiviti_surat_perancangan_negeri', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('state_id', 2);
            $table->char('daerah_id', 4);
            $table->string('surat_tahun');
            $table->date('surat_tarikh');
            $table->bigInteger('create_by')->unsigned();
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
        Schema::dropIfExists('krt__aktiviti_surat_perancangan_negeri');
    }
}
