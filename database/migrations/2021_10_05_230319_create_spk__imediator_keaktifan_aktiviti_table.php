<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpkImediatorKeaktifanAktivitiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk__imediator_keaktifan_aktiviti', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spk_imediator_id')->unsigned();
            $table->string('aktiviti_nama');
            $table->date('aktiviti_tarikh');
            $table->string('aktiviti_tempat');
            $table->string('aktiviti_jawatan');
            $table->bigInteger('ref_peringkat_id')->unsigned();
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
        Schema::dropIfExists('spk__imediator_keaktifan_aktiviti');
    }
}
