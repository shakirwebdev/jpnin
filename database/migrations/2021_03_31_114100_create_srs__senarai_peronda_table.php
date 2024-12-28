<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrsSenaraiPerondaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srs__senarai_peronda', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('srs_profile_id')->unsigned();
            $table->string('peronda_nama');
            $table->char('peronda_kad', 12);
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
        Schema::dropIfExists('srs__senarai_peronda');
    }
}
