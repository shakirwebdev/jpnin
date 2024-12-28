<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpkImediatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spk__imediator', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('hasRT', 1)->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('krt_profile_id')->unsigned()->nullable();
            $table->date('mkp_pemohon_tarikh_lahir')->nullable();
            $table->char('mkp_pemohon_parlimen_id', 4)->nullable();
            $table->char('mkp_pemohon_dun_id', 6)->nullable();
            $table->char('mkp_pemohon_pbt_id', 6)->nullable();
            $table->string('mkp_pemohon_mukim_id')->nullable();
            $table->bigInteger('mkp_pemohon_jantina_id')->unsigned()->nullable();
            $table->bigInteger('mkp_pemohon_kaum_id')->unsigned()->nullable();
            $table->longText('mkp_pemohon_alamat')->nullable();
            $table->longText('mkp_pemohon_alamat_p')->nullable();
            $table->string('mkp_pemohon_no_phone_p')->nullable();
            $table->bigInteger('mkp_pemohon_kategori_id')->unsigned()->nullable();
            $table->bigInteger('mkp_pemohon_tahap_id')->unsigned()->nullable();
            $table->bigInteger('mkp_pemohon_akademik')->unsigned()->nullable();
            $table->string('mkp_pemohon_khusus')->nullable();
            $table->date('mkp_tarikh_dilantik')->nullable();
            $table->string('mkp_file_avatar')->nullable();
            $table->bigInteger('status')->unsigned();
            $table->bigInteger('status_pelanjutan')->unsigned();
            $table->bigInteger('dihantar_by')->nullable()->unsigned();
            $table->dateTime('dihantar_date')->nullable();
            $table->bigInteger('disokong_by')->nullable()->unsigned();
            $table->dateTime('disokong_date')->nullable();
            $table->longText('disokong_note')->nullable();
            $table->bigInteger('disokong_p_by')->nullable()->unsigned();
            $table->dateTime('disokong_p_date')->nullable();
            $table->longText('disokong_p_note')->nullable();
            $table->bigInteger('disemak_by')->nullable()->unsigned();
            $table->dateTime('disemak_date')->nullable();
            $table->longText('disemak_note')->nullable();
            $table->bigInteger('dilulus_by')->nullable()->unsigned();
            $table->dateTime('dilulus_date')->nullable();
            $table->longText('dilulus_note')->nullable();
            $table->bigInteger('dilantik_by')->nullable()->unsigned();
            $table->dateTime('dilantik_date')->nullable();
            $table->longText('dilantik_note')->nullable();
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
        Schema::dropIfExists('spk__imediator');
    }
}
