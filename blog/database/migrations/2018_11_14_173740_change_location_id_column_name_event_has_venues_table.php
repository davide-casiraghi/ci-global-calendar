<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeLocationIdColumnNameEventHasVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_has_venues', function (Blueprint $table) {
            $table->renameColumn('location_id', 'venue_id');
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
            $table->renameColumn('venue_id', 'location_id');
        });
    }
}
