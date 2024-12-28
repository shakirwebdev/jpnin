<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpkImuhibbahAtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk__imuhibbah_at', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spk_imuhibbah_id')->unsigned();
            $table->string('tempoh_tindakan');
            $table->date('tarikh_arahan');
            $table->bigInteger('jenis_arahan_id')->unsigned();
            $table->string('tindakan_kepada_ppn');
            $table->string('tindakan_kepada_ppd');
            $table->bigInteger('arahan_by')->unsigned();
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
        Schema::dropIfExists('spk__imuhibbah_at');
    }
}
