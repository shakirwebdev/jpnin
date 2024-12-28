<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtKemudahanAwamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__kemudahan_awam', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profileID')->unsigned();
            $table->bigInteger('ref_kemudahan_awamID')->unsigned();
            $table->char('kemudahan_awam_jumlah', 3);
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
        Schema::dropIfExists('krt__kemudahan_awam');
    }
}
