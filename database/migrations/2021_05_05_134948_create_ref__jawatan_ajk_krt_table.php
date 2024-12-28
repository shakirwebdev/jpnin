<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefJawatanAjkKrtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref__jawatan_ajk_krt', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jawatan_description');
            $table->boolean('jawatan_status')->default(true);
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
        Schema::dropIfExists('ref__jawatan_ajk_krt');
    }
}
