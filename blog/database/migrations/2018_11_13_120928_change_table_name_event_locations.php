<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableNameEventLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('event_locations', function (Blueprint $table) {
            Schema::rename('event_locations', 'event_venues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_locations', function (Blueprint $table) {
            Schema::rename('event_venues', 'event_locations');
        });
    }
}
