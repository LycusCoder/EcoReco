<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // CATEGORIES
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique(); // 🔥 slug untuk URL
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        // PRODUCTS
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // 🔗 relasi ke kategori
            $table->string('name');
            $table->string('slug')->unique(); // 🔥 slug untuk URL
            $table->text('description');
            $table->integer('price');
            $table->string('image');
            $table->decimal('rating', 3, 1)->default(0.0);
            $table->timestamps();
        });

        // TESTIMONIALS
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi dengan users
            $table->text('message');
            $table->string('image')->nullable(); // Gambar opsional
            $table->timestamps();
        });

        // ORDERS
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });

        // ORDER ITEMS
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // harga pada saat pembelian
            $table->timestamps();
        });

        // RATINGS
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->decimal('rating', 3, 1);
            $table->timestamps();
        });

        // RECOMMENDATIONS
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->decimal('score', 5, 2); // skor rekomendasi
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recommendations');
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
