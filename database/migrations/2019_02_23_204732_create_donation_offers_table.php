<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->integer('country_id')->nullable();
            $table->string('email');
            $table->text('contact_trough_voip')->nullable();
            $table->text('language_spoken')->nullable();
            $table->integer('offer')->nullable();
            $table->integer('gift_kind')->nullable();
            $table->text('gift_description')->nullable();
            $table->integer('volunteer_kind')->nullable();
            $table->text('volunteer_description')->nullable();
            $table->text('other_description')->nullable();
            $table->text('suggestions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donation_offers');
    }
}
