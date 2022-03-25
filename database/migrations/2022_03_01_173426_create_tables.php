<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
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
            $table->string('city');
        });

        Schema::create('favoritos', function(Blueprint $table){
            $table->id();
            $table->integer('id_user');
            $table->integer('id_worker');
        });

        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone_number');
            $table->string('whatsapp');
            $table->string('avatar')->default('default.png');
            $table->float('rating');
            $table->string('address');
            $table->string('city');
            $table->bool('have_whatsapp');
        });

        Schema::create('worker_photos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_worker');
            $table->string('url');
        });

        Schema::create('worker_reviews', function (Blueprint $table){
            $table->id();
            $table->integer('id_worker');
            $table->float('rating');
        });

        Schema::create('worker_services', function (Blueprint $table) {
            $table->id();
            $table->integer('id_worker');
            $table->string('title');
            $table->float('value');
        });

        Schema::create('worker_testimonials', function (Blueprint $table){
            $table->id();
            $table->integer('id_worker');
            $table->string('name');
            $table->float('rating');
            $table->string('description');
        });

        Schema::create('worker_availability', function (Blueprint $table) {
            $table->id();
            $table->integer('id_worker');
            $table->string('start_day');
            $table->string('end_day');
            $table->integer('start_hour');
            $table->integer('end_hour');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tables');
    }
}
