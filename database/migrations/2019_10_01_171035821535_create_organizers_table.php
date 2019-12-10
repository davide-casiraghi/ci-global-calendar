<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizersTable extends Migration
{
    public function up()
    {
        Schema::create('organizers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('created_by')->nullable();

            $table->string('email');
            $table->text('description')->nullable();
            $table->integer('country_id')->nullable();

            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('phone')->nullable();

            $table->string('slug');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('organizers');
    }
}
