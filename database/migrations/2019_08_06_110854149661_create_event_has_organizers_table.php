<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventHasOrganizersTable extends Migration
{
    public function up()
    {
        Schema::create('event_has_organizers', function (Blueprint $table) {
            $table->integer('event_id');
            $table->integer('organizer_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_has_organizers');
    }
}
