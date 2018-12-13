<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSupportFieldsToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('sc_country_id')->nullable();
            $table->string('sc_country_name')->nullable();
            $table->string('sc_city_name')->nullable();
            $table->string('sc_venue_name')->nullable();
            $table->string('sc_teachers_id')->nullable();
            $table->string('sc_teachers_names')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('sc_country_id');
            $table->dropColumn('sc_country_name');
            $table->dropColumn('sc_city_name');
            $table->dropColumn('sc_venue_name');
            $table->dropColumn('sc_teachers_id');
            $table->dropColumn('sc_teachers_names');
        });
    }
}
