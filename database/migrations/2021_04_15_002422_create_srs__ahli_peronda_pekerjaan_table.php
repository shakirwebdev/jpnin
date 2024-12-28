<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrsAhliPerondaPekerjaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srs__ahli_peronda_pekerjaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('srs_profile_id')->unsigned();
            $table->string('ref_profession_id');
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
        Schema::dropIfExists('srs__ahli_peronda_pekerjaan');
    }
}
