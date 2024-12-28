<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefKemudahanAwamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref__kemudahan_awam', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('kemudahan_awam', 2)->unique();
            $table->string('kemudahan_awam_description');
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
        Schema::dropIfExists('ref__kemudahan_awam');
    }
}
