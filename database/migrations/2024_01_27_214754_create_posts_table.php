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
        Schema::create('posts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained();
            $table->string('body');
            $table->boolean('pay_per_view')->default(false);
            $table->float('payperviewamount')->nullable();
            $table->timestamp('scheduled_live_time')->nullable();
            $table->boolean('pinned')->default(false);
            $table->timestamp('pinned_at')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('repost')->default(false);
            $table->ulid('repost_original_id')->nullable();
            $table->string('repost_body')->nullable();
            $table->timestamp('repost_original_post_timestamp')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
