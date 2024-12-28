<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users__menu', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('menu_id')->unsigned()->nullable();
            $table->bigInteger('menu2nd_id')->unsigned()->nullable();
            $table->mediumText('users_menu_page_name');
            $table->mediumText('users_menu_page_icon');
            $table->mediumInteger('users_menu_turn');
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
        Schema::dropIfExists('users__menu');
    }
}
