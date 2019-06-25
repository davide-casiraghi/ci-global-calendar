<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRouteParametersToMenuItemsSecond extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('route_param_name_1')->nullable();
            $table->string('route_param_name_2')->nullable();
            $table->string('route_param_name_3')->nullable();
            $table->string('route_param_value_1')->nullable();
            $table->string('route_param_value_2')->nullable();
            $table->string('route_param_value_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('route_param_name_1');
            $table->dropColumn('route_param_name_2');
            $table->dropColumn('route_param_name_3');
            $table->dropColumn('route_param_value_1');
            $table->dropColumn('route_param_value_2');
            $table->dropColumn('route_param_value_3');
        });
    }
}
