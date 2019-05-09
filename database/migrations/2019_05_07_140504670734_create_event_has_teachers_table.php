<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventHasTeachersTable extends Migration
{
    public function up()
    {
        Schema::create('event_has_teachers', function (Blueprint $table) {
            $table->integer('event_id');
            $table->integer('teacher_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_has_teachers');
    }
}
