<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTollItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('toll_items')) {
            Schema::create('toll_items', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('toll_id')->unsigned()->nullable();
                $table->foreign('toll_id')->references('id')->on('toll')->onDelete('cascade');
                $table->integer('toll_category_id')->nullable()->unsigned();
                $table->foreign('toll_category_id')->references('id')->on('toll_category')->onUpdate('RESTRICT')->onDelete('CASCADE');
                $table->integer('axes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('toll_items');
    }
}
