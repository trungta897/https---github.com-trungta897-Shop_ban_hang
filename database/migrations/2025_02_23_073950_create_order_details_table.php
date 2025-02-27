<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('order_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->string('buyer_name')->nullable();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->string('seller_name')->nullable();
            $table->enum('status', ['Pending', 'Processing', 'Shipping', 'Delivered', 'Cancelled'])->default('Pending');
            $table->string('buyer_address');
            $table->string('buyer_phone');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('set null');
        });


    }

    public function down()
    {
        Schema::dropIfExists('order_details');
    }
};
