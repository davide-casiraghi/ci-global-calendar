<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToDonationsOffers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donation_offers', function (Blueprint $table) {
            $table->string('economic_value')->nullable();
            $table->string('estimated_volunteer_time')->nullable();
            $table->string('gift_given_to')->nullable();
            $table->string('gift_given_when')->nullable();
            $table->string('country_of_the_gift')->nullable();
            $table->string('admin_notes')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donation_offers', function (Blueprint $table) {
            //
        });
    }
}
