<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_fixed')->default(false)->after('selling_price');
            $table->json('locked_fields')->default('[]')->after('is_fixed');
            $table->json('locked_for')->default('[]')->after('locked_fields');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_fixed', 'locked_fields', 'locked_for']);
        });
    }
};