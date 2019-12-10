<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('created_by')->nullable();

            $table->text('bio')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('year_starting_practice')->nullable();
            $table->string('year_starting_teach')->nullable();
            $table->text('significant_teachers')->nullable();

            $table->string('profile_picture')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();

            $table->string('slug');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
