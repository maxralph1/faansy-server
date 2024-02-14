<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('subscribed_id')->references('id')->on('users');
            $table->foreignUlid('subscriber_id')->references('id')->on('users');
            $table->unsignedInteger('subscription_amount_paid')->default(0);
            $table->unsignedInteger('cumulative_amount_spent_by_subscriber_on_subscribed')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
