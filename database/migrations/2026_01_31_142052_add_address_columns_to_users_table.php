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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('email');
            $table->char('province_id', 2)->nullable()->after('phone_number');
            $table->char('city_id', 4)->nullable()->after('province_id');
            $table->string('postal_code')->nullable()->after('city_id');
            $table->text('address')->nullable()->after('postal_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'province_id', 'city_id', 'postal_code', 'address']);
        });
    }
};
