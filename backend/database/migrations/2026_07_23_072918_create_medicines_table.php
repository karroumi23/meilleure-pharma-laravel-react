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

            $table->string('barcode')->nullable()->unique();

            $table->string('dosage')->nullable();

            $table->string('image')->nullable();

            $table->text('description')->nullable();

            $table->decimal('price',10,2);

            $table->decimal('sale_price',10,2)->nullable();

            $table->boolean('requires_prescription')->default(false);

            $table->enum('status',[
                'active',
                'inactive'
            ])->default('active');
            
            // SKU → Internal product code (very common in inventory systems).
            $table->string('sku')->unique()->nullable();
            // Rating → Average customer rating (used on the website without recalculating every page load).
            $table->float('rating')->default(0);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
