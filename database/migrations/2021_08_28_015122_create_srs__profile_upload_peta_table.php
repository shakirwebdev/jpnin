<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrsProfileUploadPetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srs__profile_upload_peta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('srs_profile_id')->unsigned();
            $table->string('file_title');
            $table->longText('file_catatan');
            $table->string('file_peta');
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
        Schema::dropIfExists('srs__profile_upload_peta');
    }
}
