<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdToFoodMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('food_menus', function (Blueprint $table) {
            $table->unsignedBigInteger('id',true);
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('food_menus', function (Blueprint $table) {
            $table->dropColumn('id');  
            $table->dropColumn('deleted_at');
        });
    }
}
