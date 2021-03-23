<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ShoppingCardMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->unsigned();
            $table->integer('vendor_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('quantity');
            $table->boolean('isBuyed');
            $table->decimal('final_price');
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
        Schema::dropIfExists('shopping_card');
    }
}
