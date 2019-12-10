<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('created_by')->nullable();

            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->integer('venue_id');
            $table->integer('organized_by')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('website_event_link')->nullable();
            $table->string('facebook_event_link')->nullable();
            $table->string('status')->default('2')->nullable();

            $table->integer('repeat_type');
            $table->dateTime('repeat_until')->nullable();
            $table->string('repeat_weekly_on')->nullable();
            $table->string('repeat_monthly_on')->nullable();
            $table->string('on_monthly_kind')->nullable();
            $table->string('multiple_dates')->nullable();

            $table->integer('sc_country_id')->nullable();
            $table->string('sc_country_name')->nullable();
            $table->string('sc_city_name')->nullable();
            $table->string('sc_venue_name')->nullable();
            $table->string('sc_teachers_id')->nullable();
            $table->string('sc_teachers_names')->nullable();
            $table->integer('sc_continent_id')->nullable();

            $table->string('slug');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
