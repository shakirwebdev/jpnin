<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtPekerjaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__pekerjaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profileID')->unsigned();
            $table->bigInteger('profession_id')->unsigned();
            $table->char('pekerjaan_peratus', 4);
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
        Schema::dropIfExists('krt__pekerjaan');
    }
}
