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
        Schema::create('feature_sku', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'sku_id')->constrained();
            $table->foreignId(column: 'feature_id')->constrained();
            $table->string(column: 'value');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_sku');
    }
};
