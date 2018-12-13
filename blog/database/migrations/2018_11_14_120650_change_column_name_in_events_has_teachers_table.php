<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnNameInEventsHasTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_has_teachers', function (Blueprint $table) {
            $table->dropColumn('location_id');
            $table->integer('teacher_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_has_teachers', function (Blueprint $table) {
            $table->dropColumn('teacher_id');
            $table->integer('location_id');
        });
    }
}
