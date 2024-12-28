<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpkIkesDokumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk__ikes_dokument', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spk_ikes_id')->unsigned();
            $table->string('file_title');
            $table->longText('file_catatan');
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
        Schema::dropIfExists('spk__ikes_dokument');
    }
}
