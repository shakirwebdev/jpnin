<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbkStudentDokumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbk__student_dokument', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tbk_student_id')->unsigned();
            $table->string('file_title');
            $table->string('file_dokument');
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
        Schema::dropIfExists('tbk__student_dokument');
    }
}
