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
        Schema::create('notifications', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained();
            // $table->enum('notification_type', ['pay_per_view_on_post', 'pay_per_view_on_chat', 'subscription', 'tip', 'stream_tip', 'commission', 'commission_on_pay_per_view_on_post', 'commission_on_pay_per_view_on_chat', 'commission_on_subscription', 'commission_on_tip', 'commission_on_stream_tip', 'vat', 'others']);
            $table->string('notification_type');
            $table->float('monies_if_any');
            $table->ulid('reference_id_to_resource');
            $table->ulid('transactor_id');
            $table->boolean('read')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
