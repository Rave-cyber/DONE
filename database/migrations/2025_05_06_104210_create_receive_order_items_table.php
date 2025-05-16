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
        Schema::create('receive_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receive_order_id')
                ->constrained('receive_orders')
                ->onDelete('cascade');
            $table->foreignId('item_id')
                ->constrained('inventory_items')
                ->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('unit_price', 8, 2);
            $table->enum('status', ['pending', 'received'])->default('pending');
            $table->integer('stocked_in_quantity')->default(0);  // Column from the previous migration
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receive_order_items');
    }
};
