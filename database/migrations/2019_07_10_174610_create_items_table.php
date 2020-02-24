<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('item_id');
            $table->string('item_description');
            $table->integer('item_children_of');
            $table->integer('item_layer');
            $table->unsignedBigInteger('menu_id');
            $table->timestamps();
        });

        Schema::table('items', function (Blueprint $table) {         
            $table->foreign('menu_id')->references('menu_id')->on('menus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
