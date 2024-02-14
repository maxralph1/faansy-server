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
        Schema::create('userlikes', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('liked_id')->references('id')->on('users');
            $table->foreignUlid('liker_id')->references('id')->on('users');
            $table->timestamps();
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userlikes');
    }
};
