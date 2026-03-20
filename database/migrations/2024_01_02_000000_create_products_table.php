<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('strain');
            $table->string('category'); // flower, edible, concentrate, vape, preroll
            $table->string('emoji')->default('🌿');
            $table->string('thc')->nullable();
            $table->decimal('price', 8, 2);
            $table->decimal('old_price', 8, 2)->nullable();
            $table->decimal('rating', 3, 1)->default(0);
            $table->unsignedInteger('reviews')->default(0);
            $table->boolean('is_new')->default(false);
            $table->boolean('featured')->default(false);
            $table->boolean('active')->default(true);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
