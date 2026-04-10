<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add second phone to orders
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_phone2', 30)->nullable()->after('customer_phone');
        });

        // Visitor email log
        Schema::create('site_visitors', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('ip', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('customer_phone2');
        });
        Schema::dropIfExists('site_visitors');
    }
};
