<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtKeaktifanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__keaktifan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->string('keaktifan_markah')->nullable();
            $table->bigInteger('status')->unsigned()->nullable();
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
        Schema::dropIfExists('krt__keaktifan');
    }
}
