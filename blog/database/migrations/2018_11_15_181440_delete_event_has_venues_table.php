<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteEventHasVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_has_venues', function (Blueprint $table) {
            Schema::dropIfExists('event_has_venues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('event_has_venues', function (Blueprint $table) {
            $table->integer('event_id');
            $table->integer('venue_id');
        });
    }
}
