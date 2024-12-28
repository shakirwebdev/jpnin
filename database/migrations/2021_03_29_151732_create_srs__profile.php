<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrsProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srs__profile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_id')->unsigned()->nullable();
            $table->string('srs_name')->nullable();
            $table->string('srs_peronda_total')->nullable();
            $table->string('srs_kawalan')->nullable();
            $table->string('srs_status');
            $table->bigInteger('dihantar_by')->nullable()->unsigned();
            $table->dateTime('dihantar_date')->nullable();
            $table->bigInteger('disemak_by')->nullable()->unsigned();
            $table->dateTime('disemak_date')->nullable();
            $table->longText('disemak_note')->nullable();
            $table->bigInteger('disahkan_by')->nullable()->unsigned();
            $table->dateTime('disahkan_date')->nullable();
            $table->longText('disahkan_note')->nullable();
            $table->bigInteger('diakui_by')->nullable()->unsigned();
            $table->dateTime('diakui_date')->nullable();
            $table->longText('diakui_note')->nullable();
            $table->bigInteger('diluluskan_by')->nullable()->unsigned();
            $table->dateTime('diluluskan_date')->nullable();
            $table->longText('diluluskan_note')->nullable();
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
        Schema::dropIfExists('srs__profile');
    }
}
