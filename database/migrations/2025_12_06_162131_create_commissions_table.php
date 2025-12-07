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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('from_user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('user_investment_id')
                  ->nullable()
                  ->constrained('user_investments')
                  ->nullOnDelete();

            $table->enum('type', ['referral', 'level', 'binary', 'matching', 'other']);
            $table->unsignedInteger('level')->nullable();

            $table->decimal('amount', 18, 8);
            $table->decimal('percentage', 8, 4)->nullable();

            $table->enum('status', ['pending', 'credited', 'cancelled'])->default('credited');

            $table->timestamps();

            $table->index(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
