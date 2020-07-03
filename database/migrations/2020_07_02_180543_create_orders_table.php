<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->text('adress')->nullable();
            $table->integer('payment_method')->nullable();
            $table->string('order_date')->nullable();
            $table->string('order_status')->nullable();
            $table->integer('product_counts')->nullable();
            $table->double('total_price');
            $table->json('products')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');//bu islem products icindeki bir numarali urunu sildik diyelim, ona aid, product_categories deki tum kayitlari daa silmek ucundur
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
