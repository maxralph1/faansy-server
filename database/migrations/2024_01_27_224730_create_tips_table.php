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
        Schema::create('tips', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('recipient_id')->references('id')->on('users');
            $table->foreignUlid('donor_id')->references('id')->on('users');
            $table->unsignedInteger('amount');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tips');
    }
};
