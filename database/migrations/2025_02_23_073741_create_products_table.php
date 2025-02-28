<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('name', 100);
            $table->decimal('price', 15, 0);
            $table->string('image')->nullable();
            $table->string('category', 50)->nullable();
            $table->boolean('featured');
            $table->integer('stock')->nullable();
            $table->text('detail')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
        });
    }


    public function down()
    {
        Schema::dropIfExists('products');
    }
};
