<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('order_id', 50)->nullable()->unique();
            $table->string('snap_token', 100)->nullable();
            $table->text('payment_url')->nullable();
            $table->string('payment_status', 30)->nullable();
            $table->timestamp('paid_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropUnique(['order_id']);
            $table->dropColumn(['order_id', 'snap_token', 'payment_url', 'payment_status', 'paid_at']);
        });
    }
};
