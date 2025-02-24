<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 191);
            $table->foreignId('product_id')->nullable()->constrained();
            $table->string('product_name')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->foreignId('buyer_id')->nullable()->constrained('buyers');
            $table->string('buyer_name')->nullable();
            $table->foreignId('seller_id')->nullable()->constrained('sellers');
            $table->string('seller_name')->nullable();
            $table->enum('status', ['Pending','Processing','Shipping','Delivered','Cancelled'])->default('Pending');
            $table->string('buyer_address');
            $table->string('buyer_phone');
            $table->timestamps();
            $table->index('order_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_details');
    }
};
