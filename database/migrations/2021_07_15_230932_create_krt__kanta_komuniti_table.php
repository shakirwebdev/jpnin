<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrtKantaKomunitiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krt__kanta_komuniti', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('state_id', 2)->nullable();
            $table->char('daerah_id', 4)->nullable();
            $table->string('kanta_nama')->nullable();
            $table->string('kanta_alamat')->nullable();
            $table->char('kanta_jenis_kediaman_1', 1)->nullable();
            $table->char('kanta_jenis_kediaman_2', 1)->nullable();
            $table->char('kanta_jenis_kediaman_3', 1)->nullable();
            $table->char('kanta_jenis_kediaman_4', 1)->nullable();
            $table->string('kanta_sejarah_lokasi')->nullable();
            $table->longText('kanta_kelebihan_lokasi')->nullable();
            $table->longText('kanta_kemudahan')->nullable();
            $table->bigInteger('status')->unsigned()->nullable();
            $table->bigInteger('dihantar_by')->nullable()->unsigned();
            $table->dateTime('dihantar_date')->nullable();
            $table->bigInteger('disemak_by')->nullable()->unsigned();
            $table->dateTime('disemak_date')->nullable();
            $table->longText('disemak_note')->nullable();
            $table->bigInteger('disahkan_by')->nullable()->unsigned();
            $table->dateTime('disahkan_date')->nullable();
            $table->longText('disahkan_note')->nullable();
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
        Schema::dropIfExists('krt__kanta_komuniti');
    }
}
