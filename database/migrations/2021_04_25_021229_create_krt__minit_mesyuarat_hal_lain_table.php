<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtMinitMesyuaratHalLainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__minit_mesyuarat_hal_lain', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_minit_mesyuarat_id')->unsigned();
            $table->string('hal_lain_perkara');
            $table->longText('hal_lain_tindakan');
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
        Schema::dropIfExists('krt__minit_mesyuarat_hal_lain');
    }
}
