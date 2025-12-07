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
        Schema::create('user_investments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('investment_plan_id')
                  ->constrained('investment_plans')
                  ->onDelete('cascade');

            $table->decimal('amount', 18, 8);
            $table->decimal('expected_roi_total', 18, 8)->default(0);
            $table->decimal('earned_roi_total', 18, 8)->default(0);

            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();

            $table->enum('status', ['running', 'completed', 'cancelled'])->default('running');

            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_investments');
    }
};
