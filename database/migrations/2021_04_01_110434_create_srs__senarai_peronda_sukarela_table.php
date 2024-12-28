<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrsSenaraiPerondaSukarelaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srs__senarai_peronda_sukarela', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('srs_profile_id')->unsigned();
            $table->string('p_sukarela_nama');
            $table->char('p_sukarela_kad', 12);
            $table->string('jantina_id');
            $table->string('p_sukarela_pekerjaan');
            $table->string('p_sukarela_alamat_k');
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
        Schema::dropIfExists('srs__senarai_peronda_sukarela');
    }
}
