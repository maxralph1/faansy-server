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
        Schema::create('profiles', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained();
            $table->string('bio')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('website_url')->nullable();
            // $table->enum('language', ['de', 'en-US', 'fr']);
            $table->string('language')->default('en-US');
            $table->boolean('dark_mode')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
