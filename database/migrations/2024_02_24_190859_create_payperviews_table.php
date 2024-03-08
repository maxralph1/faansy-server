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
        Schema::create('payperviews', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained();
            $table->foreignUlid('message_id')->nullable()->constrained();
            $table->foreignUlid('post_id')->nullable()->constrained();
            // $table->enum('content_type', ['post', 'chat']);
            $table->string('content_type');
            $table->float('payperview_amount_paid')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payperviews');
    }
};
