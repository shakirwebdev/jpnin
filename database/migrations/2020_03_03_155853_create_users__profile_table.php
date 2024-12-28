<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users__profile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('user_fullname');
            $table->string('no_ic')->nullable();
            $table->string('no_phone')->nullable();
            $table->longText('user_address')->nullable();
            $table->char('state_id', 2)->nullable();
            $table->char('daerah_id', 4)->nullable();
            $table->bigInteger('krt_id')->unsigned()->nullable();
            $table->bigInteger('srs_id')->unsigned()->nullable();
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
        Schema::dropIfExists('users__profile');
    }
}
