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
            $table->text('description');
            $table->decimal('price', 15, 2); 
            $table->decimal('discount_price', 15, 2)->nullable(); 
            $table->integer('quantity_in_stock');
            $table->integer('quantity_sold')->default(0); 
            $table->boolean('is_available')->default(true); 
            $table->decimal('rating', 2, 1)->default(0); // Rating out of 5.0, default to 0
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null'); // Change to set null
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null'); // Change to set null
            $table->timestamps();
            $table->softDeletes();
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
