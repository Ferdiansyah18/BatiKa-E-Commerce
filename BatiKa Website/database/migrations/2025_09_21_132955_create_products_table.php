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
            $table->string('name');
            $table->string('slug');
            $table->string('thumbnail');
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('discount_price')->nullable();
            $table->dateTime('discount_start_date')->nullable();
            $table->dateTime('discount_end_date')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->text('description'); // Renamed from about
            $table->text('care_instructions')->nullable(); 
            $table->text('shipping_return')->nullable();
            $table->json('specifications')->nullable(); // For material, dimensions, etc.
            $table->boolean('is_featured')->default(false);
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
