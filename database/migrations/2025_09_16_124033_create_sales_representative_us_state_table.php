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
        Schema::create('sales_representative_us_state', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_representative_id')->constrained()->onDelete('cascade');
            $table->foreignId('us_state_id')->constrained()->onDelete('cascade');
            // $table->unique(['sales_representative_id', 'us_state_id']);
            // We added below one due to - MySQL has a max identifier length of 64 characters
            $table->unique(
                ['sales_representative_id', 'us_state_id'],
                'rep_state_unique'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_representative_us_state');
    }
};
