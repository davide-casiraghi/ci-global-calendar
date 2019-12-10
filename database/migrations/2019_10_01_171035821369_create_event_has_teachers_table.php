<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
