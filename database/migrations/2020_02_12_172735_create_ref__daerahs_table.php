<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefDaerahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref__daerahs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('daerah_id', 4)->unique();
            $table->string('daerah_description');
            $table->char('state_id', 2);            
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
        Schema::dropIfExists('ref__daerahs');
    }
}
