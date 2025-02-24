<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('product_images', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')
              ->constrained('products') // Tham chiếu đến bảng products
              ->onDelete('cascade');     // Xóa ảnh khi product bị xóa
        $table->string('image');
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('product_images');
    }
};
