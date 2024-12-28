<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpkIkesTerlibatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk__ikes_terlibat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spk_ikes_id')->unsigned();
            $table->bigInteger('ref_spk_terlibat_id')->unsigned();
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
        Schema::dropIfExists('spk__ikes_terlibat');
    }
}