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
        Schema::create('follow_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('follower_id');
            $table->string('following_id');
            $table->string('reward');
            $table->string('follow_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_transactions');
    }
};
