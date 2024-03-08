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
        Schema::create('transactions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('beneficiary_id')->references('id')->on('users');
            $table->foreignUlid('transactor_id')->references('id')->on('users');
            // $table->enum('transaction_type', ['pay_per_view_on_post', 'pay_per_view_on_chat', 'subscription', 'tip', 'stream_tip', 'commission', 'commission_on_pay_per_view_on_post', 'commission_on_pay_per_view_on_chat', 'commission_on_subscription', 'commission_on_tip', 'commission_on_stream_tip', 'vat', 'others']);
            $table->string('transaction_type');
            $table->float('amount');
            $table->ulid('reference_id_to_resource');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
