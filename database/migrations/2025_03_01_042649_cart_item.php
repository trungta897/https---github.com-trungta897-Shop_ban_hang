<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->string('name');
            $table->string('image');
            $table->integer('quantity');
            $table->decimal('price',15,0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->index('user_id');
            $table->index('product_id');
            $table->unique(['user_id', 'product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};
