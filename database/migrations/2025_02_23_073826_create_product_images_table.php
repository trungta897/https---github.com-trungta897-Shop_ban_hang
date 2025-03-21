<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('product_images', function (Blueprint $table) {
        $table->engine = 'InnoDB';
        $table->id();
        $table->unsignedBigInteger('product_id');
        $table->string('image');
        $table->timestamp('created_at')->nullable();

        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    });
}

    public function down()
    {
        Schema::dropIfExists('product_images');
    }
};
