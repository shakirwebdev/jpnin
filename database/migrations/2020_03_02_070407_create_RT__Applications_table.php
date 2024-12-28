<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRTApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('rt__applications', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->string('user_fullname');
            $table->string('no_ic');
            $table->string('no_phone');
            $table->string('user_address');
            $table->char('daerah_id', 4);
            $table->char('state_id', 2);
            $table->string('krt_name');
            $table->longText('krt_note')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('is_edit')->default(false);
            $table->bigInteger('submitby_user_id');
            $table->bigInteger('disemak_by')->nullable()->unsigned();
            $table->dateTime('disemak_date')->nullable();
            $table->longText('disemak_note')->nullable();
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
        Schema::dropIfExists('rt__applications');
    }
}
