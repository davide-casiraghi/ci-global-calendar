<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('created_by');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('image')->nullable();
            $table->integer('organized_by')->nullable();
            $table->string('facebook_link')->nullable();
            $table->enum('status', ['PUBLISHED', 'UNPUBLISHED'])->default('PUBLISHED');
            $table->timestamps();
        });
        Schema::create('event_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('name');
            $table->timestamps();
        });
        Schema::create('event_repetitions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->dateTime('start_repeat');
            $table->dateTime('end_repeat');
        });
        Schema::create('event_has_locations', function (Blueprint $table) {
            $table->integer('event_id');
            $table->integer('location_id');
        });
        Schema::create('event_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('created_by');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook_link')->nullable();
            $table->integer('continent_id');
            $table->integer('country_id');
            $table->string('city');
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->timestamps();
        });
        Schema::create('event_continents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('event_countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('event_has_teachers', function (Blueprint $table) {
            $table->integer('event_id');
            $table->integer('location_id');
        });
        Schema::create('event_teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('created_by');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('bio')->nullable();
            $table->string('image')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook_link')->nullable();
            $table->timestamps();
        });
        Schema::create('event_organizers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('created_by');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('phone')->nullable();
            $table->string('mail')->nullable();
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
        Schema::dropIfExists('events');
        Schema::dropIfExists('event_categories');
        Schema::dropIfExists('event_repetitions');
        Schema::dropIfExists('event_has_locations');
        Schema::dropIfExists('event_locations');
        Schema::dropIfExists('event_continents');
        Schema::dropIfExists('event_countries');
        Schema::dropIfExists('event_has_teachers');
        Schema::dropIfExists('event_teachers');
        Schema::dropIfExists('event_organizers');
    }
}
