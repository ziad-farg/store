<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2)->default(0);
            $table->float('compare_price', 10, 2)->nullable();
            $table->unsignedSmallInteger('quantity')->default(0);
            $table->json('options')->nullable()->comment('e.g., color, size, etc.');
            $table->float('rating')->default(0);
            $table->boolean('featured')->default(false)->comment('1: featured product, 0: not featured product');
            $table->tinyInteger('status')->default(1)->comment('1: active, 2:draft, 3: inactive');
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
