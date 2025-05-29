<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_sku', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'order_id')->constrained();
            $table->foreignId(column: 'sku_id')->constrained();
            $table->json(column: 'product');
            $table->integer(column: 'quantity');
            $table->decimal(column: 'unitary_price', total: 10, places: 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_sku');
    }
};
