<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpkImediatorMediasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk__imediator_mediasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ref_mkp_kategori_id')->unsigned()->nullable();
            $table->date('mediasi_tarikh')->nullable();
            $table->string('mediasi_alamat')->nullable();
            $table->bigInteger('spk_imediator_id')->unsigned()->nullable();
            $table->string('mediasi_pembantu_nama')->nullable();
            $table->string('mediasi_pembantu_ic')->nullable();
            $table->string('mediasi_pembantu_phone')->nullable();
            $table->string('mediasi_ngo_terlibat')->nullable();
            $table->string('mediasi_ringkasan_kes')->nullable();
            $table->bigInteger('ref_spk_mkp_peringkat_id')->unsigned()->nullable();
            $table->string('mediasi_status_kes')->nullable();
            $table->string('mediasi_note_penyelesaian_kes')->nullable();
            $table->string('mediasi_note_sebab_kes_xberjaya')->nullable();
            $table->bigInteger('status')->unsigned()->nullable();
            $table->bigInteger('dihantar_by')->nullable()->unsigned();
            $table->dateTime('dihantar_date')->nullable();
            $table->bigInteger('disokong_by')->nullable()->unsigned();
            $table->dateTime('disokong_date')->nullable();
            $table->longText('disokong_note')->nullable();
            $table->bigInteger('disokong_p_by')->nullable()->unsigned();
            $table->dateTime('disokong_p_date')->nullable();
            $table->longText('disokong_p_note')->nullable();
            $table->bigInteger('disahkan_by')->nullable()->unsigned();
            $table->dateTime('disahkan_date')->nullable();
            $table->longText('disahkan_note')->nullable();
            $table->bigInteger('disemak_by')->nullable()->unsigned();
            $table->dateTime('disemak_date')->nullable();
            $table->longText('disemak_note')->nullable();
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
        Schema::dropIfExists('spk__imediator_mediasi');
    }
}
