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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('wallet_id')
                  ->constrained('wallets')
                  ->onDelete('cascade');

            $table->enum('tx_type', ['credit', 'debit']);

            $table->enum('source_type', [
                'deposit',
                'withdrawal',
                'investment',
                'roi',
                'referral_bonus',
                'level_income',
                'binary_income',
                'admin_adjustment'
            ]);

            $table->unsignedBigInteger('source_id')->nullable();

            $table->decimal('amount', 18, 8);
            $table->decimal('balance_before', 18, 8)->default(0);
            $table->decimal('balance_after', 18, 8)->default(0);

            $table->string('currency', 10)->default('INR');
            $table->string('reference_no')->nullable();
            $table->text('remark')->nullable();

            $table->timestamp('transaction_password_verified_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'wallet_id']);
            $table->index(['source_type', 'source_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
