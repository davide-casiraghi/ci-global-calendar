<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRepeatTypeEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('repeat_type');
            $table->dateTime('repeat_until');
            $table->string('weekly_on');
            $table->string('monthly_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('repeat_type');
            $table->dropColumn('repeat_until');
            $table->dropColumn('weekly_on');
            $table->dropColumn('monthly_on');
        });
    }
}
