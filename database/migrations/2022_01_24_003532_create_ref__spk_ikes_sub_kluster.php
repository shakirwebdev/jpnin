<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefSpkIkesSubKluster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref__spk_ikes_sub_kluster', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kluster_id')->unsigned();
            $table->string('subkluster_description');
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
        Schema::dropIfExists('ref__spk_ikes_sub_kluster');
    }
}
