<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableNameEventHasLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_has_locations', function (Blueprint $table) {
            Schema::rename('event_has_locations', 'event_has_venues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_has_venues', function (Blueprint $table) {
            Schema::rename('event_has_venues', 'event_has_locations');
        });
    }
}
