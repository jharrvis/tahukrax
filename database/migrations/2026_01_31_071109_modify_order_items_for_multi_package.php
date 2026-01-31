<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Make 'package_id' in 'orders' nullable (as packages will now be in order_items)
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('package_id')->nullable()->change();
        });

        // 2. Modify 'order_items' to support both Packages and Addons
        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('addon_id')->nullable()->change(); // Addons are now optional per line item
            $table->unsignedBigInteger('package_id')->nullable()->after('order_id'); // Link to packages directly
            $table->string('item_type')->default('addon')->after('quantity'); // 'package' or 'addon'

            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->dropColumn(['package_id', 'item_type']);
            $table->unsignedBigInteger('addon_id')->nullable(false)->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            // Warning: Reverse migration might fail if orders exist with null package_id
            $table->unsignedBigInteger('package_id')->nullable(false)->change();
        });
    }
};
