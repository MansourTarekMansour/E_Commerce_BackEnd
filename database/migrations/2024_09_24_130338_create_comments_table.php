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
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); 
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('cascade'); // Reference the customers table
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // For both admins and customers
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade'); // For replies
            $table->text('content'); 
            $table->integer('rate')->nullable(); 
            $table->timestamps();
            
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
