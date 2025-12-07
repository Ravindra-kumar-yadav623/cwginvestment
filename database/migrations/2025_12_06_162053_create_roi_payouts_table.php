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
        Schema::create('roi_payouts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_investment_id')
                  ->constrained('user_investments')
                  ->onDelete('cascade');

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->decimal('amount', 18, 8);
            $table->date('roi_date');
            $table->enum('status', ['pending', 'paid', 'failed'])->default('paid');

            $table->timestamps();

            $table->index(['user_id', 'roi_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roi_payouts');
    }
};
