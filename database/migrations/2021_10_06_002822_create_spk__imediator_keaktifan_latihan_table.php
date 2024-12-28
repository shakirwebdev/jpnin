<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpkImediatorKeaktifanLatihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk__imediator_keaktifan_latihan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spk_imediator_id')->unsigned();
            $table->string('latihan_nama');
            $table->date('latihan_tarikh');
            $table->string('latihan_tempat');
            $table->string('latihan_penganjur');
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
        Schema::dropIfExists('spk__imediator_keaktifan_latihan');
    }
}
