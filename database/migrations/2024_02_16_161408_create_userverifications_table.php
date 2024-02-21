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
        Schema::create('userverifications', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('requesting_user_id')->references('id')->on('users');
            $table->foreignUlid('approving_user_id')->nullable()->references('id')->on('users');
            $table->string('verification_material_image_url');
            $table->boolean('approved')->default(false);
            $table->timestamp('approval_time')->nullable();
            $table->boolean('rejected')->nullable();
            $table->string('reason_for_rejection')->nullable();
            $table->timestamp('rejection_time')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userverifications');
    }
};
