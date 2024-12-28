<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrsAhliPerondaPendidikanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srs__ahli_peronda_pendidikan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('srs_profileID')->unsigned();
            $table->tinyInteger('ref_pendidikanID')->unsigned();
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
        Schema::dropIfExists('srs__ahli_peronda_pendidikan');
    }
}
