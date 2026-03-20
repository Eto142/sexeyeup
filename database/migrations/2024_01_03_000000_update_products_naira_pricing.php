<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price_gram',  10, 2)->default(0)->after('thc');
            $table->decimal('price_ounce', 10, 2)->default(0)->after('price_gram');
            $table->dropColumn(['price', 'old_price']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price',     8, 2)->default(0)->after('thc');
            $table->decimal('old_price', 8, 2)->nullable()->after('price');
            $table->dropColumn(['price_gram', 'price_ounce']);
        });
    }
};
