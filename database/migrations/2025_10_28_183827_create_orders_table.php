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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('number')->unique();
            $table->tinyInteger('status')->default(1)->comment('1: PENDING, 2: PROCESSING, 3: COMPLETED, 4: CANCELLED, 5: REFUNDED, 6: DELIVERING');
            $table->tinyInteger('payment_status')->default(1)->comment('1: PENDING, 2: PAID, 3: FAILED');
            $table->tinyInteger('payment_method')->default(1)->comment('1: COD(Cash On Delivery), 2: CREDIT_CARD, 3: PAYPAL, 4: BANK_TRANSFER');
            $table->decimal('shipping', 8, 2)->default(0);
            $table->decimal('tax', 8, 2)->default(0);
            $table->decimal('discount', 8, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
