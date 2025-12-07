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
         Schema::create('user_networks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('sponsor_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->foreignId('upline_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->enum('position', ['left', 'right'])->nullable();

            // Level from root/upline (optional)
            $table->unsignedInteger('level')->default(0);

            $table->timestamps();

            $table->unique('user_id');
            $table->index('sponsor_id');
            $table->index(['upline_id', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_networks');
    }
};
