<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('grand_total', 10, 2);
            $table->enum('status', ['pending', 'settlement', 'cooked'])->default('pending');
            $table->integer('table_number');
            $table->enum('payment_method', ['qris', 'tunai'])->default('qris');
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
