<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpkIkesKedudukanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk__ikes_kedudukan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spk_ikes_id')->unsigned();
            $table->string('jenis_harta');
            $table->string('nilai_anggaran_kerosakan');
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
        Schema::dropIfExists('spk__ikes_kedudukan');
    }
}
