<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTollCategoryIdInProviderType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provider_type', function (Blueprint $table) {
            if (!Schema::hasColumn('provider_type', 'toll_category_id')) {
                $table->integer('toll_category_id')->unsigned()->nullable();
                $table->foreign('toll_category_id')->references('id')->on('toll_category')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provider_type', function (Blueprint $table) {
            if (Schema::hasColumn('provider_type', 'toll_category_id')) {
                $table->dropForeign('provider_type_toll_category_id_foreign');
                $table->dropColumn('toll_category_id');
            }
        });
    }
}
