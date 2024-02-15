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
        Schema::create('fanactivities', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('fan_id')->references('id')->on('users');
            $table->foreignUlid('creator_id')->references('id')->on('users');
            $table->integer('amount_paid_in_pay_per_view')->nullable();
            $table->integer('amount_paid_in_subscription')->nullable();
            $table->integer('amount_paid_in_stream_tip')->nullable();
            $table->integer('amount_paid_in_tip')->nullable();
            $table->integer('cumulative_amount_spent_on_creator_by_fan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fanactivities');
    }
};
