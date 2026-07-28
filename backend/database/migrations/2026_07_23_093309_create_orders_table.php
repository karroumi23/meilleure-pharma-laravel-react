<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('order_number')->unique();

            $table->decimal('subtotal',10,2)->default(0);

            $table->decimal('shipping_cost',10,2)->default(0);

            $table->decimal('discount',10,2)->default(0);

            $table->decimal('total',10,2);

            $table->enum('status',[
                'pending',
                'confirmed',
                'preparing',
                'shipped',
                'delivered',
                'cancelled'
            ])->default('pending');

            $table->enum('payment_status',[
                'unpaid',
                'paid',
                'refunded'
            ])->default('unpaid');

            $table->string('payment_method')->nullable();

            $table->string('phone');

            $table->string('city');

            $table->text('address');

            $table->text('note')->nullable();

            $table->timestamp('ordered_at')->nullable();

            $table->timestamp('delivered_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};