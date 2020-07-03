<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('size', 100)->nullable();
            $table->string('color', 100)->nullable();
            $table->enum('is_new',['0','1'])->default(false);
            $table->integer('discount')->nullable()->default(0);
            $table->integer('category_id')->nullable();
            $table->integer('child_category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('color');
            $table->dropColumn('size');
            $table->dropColumn('is_new');
            $table->dropColumn('discount');
            $table->dropColumn('category_id');
            $table->dropColumn('child_category_id');
        });
    }
}
