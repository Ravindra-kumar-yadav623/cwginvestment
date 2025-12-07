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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('request_for');              // e.g. "Robo" or wallet label
            $table->string('request_wallet_address');   // 0xC45f...
            $table->string('currency')->default('USDT.BEP20');
            $table->decimal('amount', 16, 8);           // crypto amount
            $table->string('user_crypto_address');      // user's sending wallet
            $table->string('proof_image')->nullable();  // file path

            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending');

            $table->text('admin_remark')->nullable();

            $table->timestamps();
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
