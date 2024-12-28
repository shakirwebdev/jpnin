<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefDUNSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref__duns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('dun_id', 5)->unique();
            $table->string('dun_description');
            $table->string('parlimen_id');
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
        Schema::dropIfExists('ref__duns');
    }
}
