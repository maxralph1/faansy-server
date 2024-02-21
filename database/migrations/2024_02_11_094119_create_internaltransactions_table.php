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
        Schema::create('internaltransactions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->enum('transaction_type', ['commission_on_pay_per_view', 'commission_on_subscription', 'commission_on_stream_tip', 'commission_on_tip', 'commission_on_vat']);
            $table->float('amount');
            $table->ulid('reference_id_to_resource');
            $table->ulid('reference_id_to_transaction');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internaltransactions');
    }
};
