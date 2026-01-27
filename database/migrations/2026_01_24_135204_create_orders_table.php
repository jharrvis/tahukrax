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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('partnership_id')->nullable()->constrained();
            $table->foreignId('package_id')->constrained();
            $table->decimal('total_amount', 15, 2);
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->string('status')->default('pending'); // pending, paid, processing, shipping, completed, cancelled
            $table->string('tracking_number')->nullable();
            $table->text('note')->nullable();
            $table->string('xendit_invoice_id')->nullable();
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
