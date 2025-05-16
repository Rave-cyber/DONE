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
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')
                ->constrained('inventory_items')
                ->onDelete('cascade');  // If an item is deleted, its transactions are also deleted
            $table->foreignId('supplier_id')
                ->nullable()
                ->constrained('suppliers')
                ->onDelete('set null');  // If a supplier is deleted, set supplier_id to null
            $table->enum('transaction_type', ['stock_in', 'stock_out']);
            $table->string('reason')->nullable();
            $table->integer('quantity');
            $table->decimal('price', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};
