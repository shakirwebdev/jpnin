<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbkStudentPengesahanPenjagaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbk__student_pengesahan_penjaga', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tbk_student_id')->unsigned();
            $table->bigInteger('ref_pengesahan_id')->unsigned();
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
        Schema::dropIfExists('tbk__student_pengesahan_penjaga');
    }
}
