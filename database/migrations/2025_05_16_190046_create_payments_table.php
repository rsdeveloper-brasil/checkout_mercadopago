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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'external_id')->nullable();//ID DE PAGAMENTO NO GATE MERCADO PAGO
            $table->foreignId(column: 'order_id')->constrained();
            $table->integer(column: 'method');
            $table->integer(column: 'status');
            $table->integer(column: 'installments')->nullable();
            $table->dateTime(column: 'approved_at')->nullable();
            $table->text(column: 'qr_code_64')->nullable();
            $table->text(column: 'qr_code')->nullable();
            $table->text(column: 'ticket_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
