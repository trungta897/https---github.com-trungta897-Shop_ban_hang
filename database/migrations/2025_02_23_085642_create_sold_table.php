<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('sold', function (Blueprint $table) {
        $table->engine = 'InnoDB';
        $table->id();
        $table->unsignedBigInteger('product_id')->nullable();
        $table->unsignedBigInteger('seller_id')->nullable();
        $table->string('product_name');
        $table->integer('quantity_sold');
        $table->timestamps();

        $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        $table->foreign('seller_id')->references('id')->on('users')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sold');
    }
};
