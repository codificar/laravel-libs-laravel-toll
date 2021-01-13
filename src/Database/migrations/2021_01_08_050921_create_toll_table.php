<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('toll')) {
            Schema::create('toll', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('highway')->nullable();
                $table->string('km')->nullable();
                $table->string('category')->nullable();
                $table->integer('axis')->nullable();
                $table->string('category_description')->nullable();
                $table->float('value')->nullable();
                $table->point('position')->nullable();
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
        Schema::dropIfExists('toll');
    }
}
