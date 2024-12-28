<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpkIkesBilanganCederaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk__ikes_bilangan_cedera', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spk_ikes_id')->unsigned();
            $table->bigInteger('kaum_id')->unsigned();
            $table->string('jumlah_cedera_ringan');
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
        Schema::dropIfExists('spk__ikes_bilangan_cedera');
    }
}
