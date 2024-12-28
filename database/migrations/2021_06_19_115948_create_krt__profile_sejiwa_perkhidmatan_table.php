<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtProfileSejiwaPerkhidmatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__profile_sejiwa_perkhidmatan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sejiwa_id')->unsigned();
            $table->longText('perkhidmatan_sejiwa_keperluan');
            $table->string('perkhidmatan_sejiwa_perkhidmatan');
            $table->string('perkhidmatan_sejiwa_kerjasama');
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
        Schema::dropIfExists('krt__profile_sejiwa_perkhidmatan');
    }
}
