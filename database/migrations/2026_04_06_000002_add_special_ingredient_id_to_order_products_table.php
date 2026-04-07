<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->foreignId('special_ingredient_id')
                ->nullable()
                ->after('product_id')
                ->constrained('ingredients')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('special_ingredient_id');
        });
    }
};