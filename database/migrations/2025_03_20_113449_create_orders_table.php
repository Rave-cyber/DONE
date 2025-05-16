<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_name');
            $table->decimal('weight', 8, 2);
            $table->date('date');
            $table->string('service_type');
            $table->string('status')->default('Pending');
            $table->string('payment_method');
            $table->decimal('amount', 8, 2);
            $table->text('special_instructions')->nullable();
            $table->string('payment_status')->default('pending');
            $table->boolean('is_archived')->default(false);
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
