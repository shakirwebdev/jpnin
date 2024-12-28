<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefJenisPertubuhanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref__jenis_pertubuhan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('jenis_pertubuhan', 2)->unique();
            $table->string('jenis_pertubuhan_description');
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('ref__jenis_pertubuhan');
    }
}
