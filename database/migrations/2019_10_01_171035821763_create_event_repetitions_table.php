<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventRepetitionsTable extends Migration
{
    public function up()
    {
        Schema::create('event_repetitions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->dateTime('start_repeat');
            $table->dateTime('end_repeat');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_repetitions');
    }
}
