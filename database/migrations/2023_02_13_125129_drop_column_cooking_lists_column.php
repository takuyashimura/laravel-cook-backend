<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnCookingListsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cooking_lists', function (Blueprint $table) {
            $table->dropColumn('servings');
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cooking_lists', function (Blueprint $table) {
            $table->boolean('servings')->default(false);
            $table->boolean('name')->default(false);
        });
    }
}
