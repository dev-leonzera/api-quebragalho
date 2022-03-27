<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('avatar')->default('default.png');
            $table->string('email')->unique();
            $table->string('password');
        });
        Schema::create('userfavorites', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_worker');
        });
        // Schema::create('userappointments', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('id_user');
        //     $table->integer('id_barber');
        //     $table->integer('id_service');
        //     $table->datetime('ap_datetime');
        // });

        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('avatar')->default('default.png');
            $table->float('stars')->default(0);
            $table->string('city')->nullable();
        });
        Schema::create('workerphotos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_worker');
            $table->string('url');
        });
        Schema::create('workerreviews', function (Blueprint $table) {
            $table->id();
            $table->integer('id_worker');
            $table->float('rate');
        });
        Schema::create('workerservices', function (Blueprint $table) {
            $table->id();
            $table->integer('id_worker');
            $table->string('name');
            $table->float('price');
        });
        Schema::create('workertestimonials', function (Blueprint $table) {
            $table->id();
            $table->integer('id_worker');
            $table->string('name');
            $table->float('rate');
            $table->string('body');
        });
        Schema::create('workeravailability', function (Blueprint $table) {
            $table->id();
            $table->integer('id_worker');
            $table->integer('weekday');
            $table->text('hours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('userfavorites');
        // Schema::dropIfExists('userappointments');
        Schema::dropIfExists('workers');
        Schema::dropIfExists('workerphotos');
        Schema::dropIfExists('workerreviews');
        Schema::dropIfExists('workerservices');
        Schema::dropIfExists('workertestimonials');
        Schema::dropIfExists('workeravailability');
    }
}
