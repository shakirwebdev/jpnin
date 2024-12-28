<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtProfileSkuadUnitiBiroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__profile_skuad_uniti_biro', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('skuad_uniti_id')->unsigned();
            $table->string('biro_nama');
            $table->string('biro_nama_penuh');
            $table->string('biro_ic');
            $table->string('biro_phone');
            $table->string('biro_emel');
            $table->string('biro_pekerjaan');
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
        Schema::dropIfExists('krt__profile_skuad_uniti_biro');
    }
}
