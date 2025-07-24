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
        Schema::create('reach_us_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email');
            $table->string('phone', 20);
            $table->string('company_name', 100);
            $table->string('company_website')->nullable();
            $table->string('street_address', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 50);
            $table->string('country', 60);
            $table->string('postcode', 20)->nullable();
            $table->string('contact_reason', 100);
            $table->string('message')->nullable();
            $table->string('document')->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reach_us_enquiries');
    }
};
