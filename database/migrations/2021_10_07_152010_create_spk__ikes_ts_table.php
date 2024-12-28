<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpkIkesTsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk__ikes_ts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spk_ikes_at_id')->unsigned();
            $table->date('tarikh_tindakan');
            $table->string('keterangan_tindakan');
            $table->bigInteger('tindakan_susulan_by')->unsigned();
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
        Schema::dropIfExists('spk__ikes_ts');
    }
}
