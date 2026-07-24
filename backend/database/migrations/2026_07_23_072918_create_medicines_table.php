<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {

            $table->id();

            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('brand_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');

            $table->string('slug')->unique();

            $table->string('sku')->unique()->nullable();

            $table->string('barcode')->unique()->nullable();

            $table->string('dosage')->nullable();

            $table->string('image')->nullable();

            $table->text('description')->nullable();

            $table->decimal('price', 10, 2);

            $table->decimal('sale_price', 10, 2)->nullable();

            // NEW
            $table->integer('stock')->default(0);

            // NEW
            $table->integer('minimum_stock')->default(5);

            // NEW
            $table->date('expiry_date')->nullable();

            $table->boolean('requires_prescription')->default(false);

            // NEW
            $table->boolean('featured')->default(false);

            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $table->float('rating')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};