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
        Schema::create('investment_plans', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->decimal('min_amount', 18, 8);
            $table->decimal('max_amount', 18, 8)->nullable();
            $table->decimal('roi_percent_per_period', 8, 4);
            $table->enum('roi_period', ['daily', 'weekly', 'monthly']);
            $table->unsignedInteger('duration_in_days')->nullable();
            $table->boolean('is_compounding')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_plans');
    }
};
