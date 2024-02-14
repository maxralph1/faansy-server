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
        Schema::create('users', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('role_id')->constrained();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('user_image_url')->nullable();
            $table->string('user_background_image_url')->nullable();
            $table->timestamp('last_seen')->nullable();
            $table->boolean('show_activity_status')->default(true);
            $table->boolean('users_must_be_subscribed_to_view_my_content')->default(false);
            $table->boolean('free_subscription')->default(true);
            $table->unsignedInteger('subscription_amount')->nullable();
            $table->boolean('show_subscription_offers')->default(true);
            $table->string('passport_image_url')->nullable();
            $table->boolean('verified')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
