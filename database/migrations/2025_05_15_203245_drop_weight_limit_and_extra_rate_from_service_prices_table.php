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
        Schema::table('service_prices', function (Blueprint $table) {
            $table->dropColumn(['weight_limit', 'extra_rate']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_prices', function (Blueprint $table) {
            $table->decimal('weight_limit', 8, 2)->after('base_price');
            $table->decimal('extra_rate', 8, 2)->after('weight_limit');
        });
    }
};
