<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->enum('deposit_type', ['fixed', 'percent'])->nullable()->after('price_final');
            $table->decimal('deposit_amount', 10, 2)->nullable()->after('deposit_type');
            $table->string('deposit_link_token')->nullable()->unique()->after('deposit_paid');
            $table->timestamp('deposit_link_sent_at')->nullable()->after('deposit_link_token');
        });
    }

    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn([
                'deposit_type',
                'deposit_amount',
                'deposit_link_token',
                'deposit_link_sent_at',
            ]);
        });
    }
};
