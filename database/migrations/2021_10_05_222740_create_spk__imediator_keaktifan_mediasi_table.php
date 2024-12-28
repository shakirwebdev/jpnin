<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpkImediatorKeaktifanMediasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk__imediator_keaktifan_mediasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spk_mkp_keaktifan_id')->unsigned();
            $table->bigInteger('ref_spk_mkp_mediasi_id')->unsigned();
            $table->bigInteger('ref_spk_mkp_mediasi_status_id')->unsigned();
            $table->bigInteger('ref_spk_mkp_peringkat_id')->unsigned();
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
        Schema::dropIfExists('spk__imediator_keaktifan_mediasi');
    }
}
