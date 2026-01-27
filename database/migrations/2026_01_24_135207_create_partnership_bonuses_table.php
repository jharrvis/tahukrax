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
        Schema::create('partnership_bonuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partnership_id')->constrained()->onDelete('cascade');
            $table->foreignId('bonus_id')->constrained()->onDelete('cascade');
            $table->timestamp('granted_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partnership_bonuses');
    }
};
