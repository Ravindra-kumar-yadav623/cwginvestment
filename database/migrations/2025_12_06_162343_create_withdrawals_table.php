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
         Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->decimal('amount', 18, 8);
            $table->string('currency', 10)->default('INR');

            $table->string('payout_method', 50)->nullable();
            $table->json('payout_details')->nullable();

            $table->enum('status', ['pending', 'processing', 'completed', 'rejected'])->default('pending');

            $table->timestamp('transaction_password_verified_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
