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
            $table->string('gift_donater')->nullable();
            $table->string('gift_economic_value')->nullable();
            $table->string('gift_volunteer_time_value')->nullable();
            $table->string('gift_given_to')->nullable();
            $table->dateTime('gift_given_when')->nullable();
            $table->integer('gift_country_of')->nullable();
            $table->text('admin_notes')->nullable();
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
            $table->dropColumn('gift_donater');
            $table->dropColumn('gift_economic_value');
            $table->dropColumn('gift_volunteer_time_value');
            $table->dropColumn('gift_given_to');
            $table->dropColumn('gift_given_when');
            $table->dropColumn('gift_country_of');
            $table->dropColumn('admin_notes');
        });
    }
}
