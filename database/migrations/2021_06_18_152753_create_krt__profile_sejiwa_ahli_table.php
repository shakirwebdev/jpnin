<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtProfileSejiwaAhliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__profile_sejiwa_ahli', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sejiwa_id')->unsigned();
            $table->string('ahli_sejiwa_nama');
            $table->string('ahli_sejiwa_ic');
            $table->string('ahli_sejiwa_pekerjaan');
            $table->bigInteger('kaum_id')->unsigned();
            $table->string('ahli_sejiwa_jawatan');
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
        Schema::dropIfExists('krt__profile_sejiwa_ahli');
    }
}
