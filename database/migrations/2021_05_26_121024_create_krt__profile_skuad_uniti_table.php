<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtProfileSkuadUnitiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__profile_skuad_uniti', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->string('skuad_nama')->nullable();
            $table->date('skuad_tarikh_ditubuhkan')->nullable();
            $table->longText('skuad_skop_perkhidmatan')->nullable();
            $table->string('skuad_nama_ketua')->nullable();
            $table->string('skuad_ic_ketua')->nullable();
            $table->string('skuad_email_ketua')->nullable();
            $table->string('skuad_phone_ketua')->nullable();
            $table->longText('skuad_alamat_ketua')->nullable();
            $table->string('skuad_pekerjaan_ketua')->nullable();
            $table->string('skuad_nama_setiausaha')->nullable();
            $table->string('skuad_ic_setiausaha')->nullable();
            $table->string('skuad_phone_setiausaha')->nullable();
            $table->string('skuad_email_setiausaha')->nullable();
            $table->longText('skuad_alamat_setiausaha')->nullable();
            $table->string('skuad_pekerjaan_setiausaha')->nullable();
            $table->bigInteger('status')->unsigned()->nullable();
            $table->bigInteger('dihantar_by')->nullable()->unsigned();
            $table->dateTime('dihantar_date')->nullable();
            $table->bigInteger('disemak_by')->nullable()->unsigned();
            $table->dateTime('disemak_date')->nullable();
            $table->longText('disemak_note')->nullable();
            $table->bigInteger('diakui_by')->nullable()->unsigned();
            $table->dateTime('diakui_date')->nullable();
            $table->longText('diakui_note')->nullable();
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
        Schema::dropIfExists('krt__profile_skuad_uniti');
    }
}
