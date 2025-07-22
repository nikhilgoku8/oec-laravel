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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fname', 50);
            $table->string('lname', 50);
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->string('password')->nullable();
            $table->dateTime('last_password_changed')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->integer('login_attempts')->default(0);
            $table->boolean('is_locked')->default(false);
            $table->dateTime('registered_at')->nullable();
            $table->string('billing_first_name', 50)->nullable();
            $table->string('billing_last_name', 50)->nullable();
            $table->string('billing_phone', 20)->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_company')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_city', 100)->nullable();
            $table->string('billing_state', 50)->nullable();
            $table->string('billing_country', 60)->nullable();
            $table->string('billing_postcode', 20)->nullable();
            $table->boolean('same_address')->default(true);
            $table->string('shipping_first_name', 50)->nullable();
            $table->string('shipping_last_name', 50)->nullable();
            $table->string('shipping_phone', 20)->nullable();
            $table->string('shipping_email')->nullable();
            $table->string('shipping_company')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_city', 100)->nullable();
            $table->string('shipping_state', 50)->nullable();
            $table->string('shipping_country', 60)->nullable();
            $table->string('shipping_postcode', 20)->nullable();
            $table->boolean('paying_customer')->default(false);
            $table->string('status', 16)->default('pending')->comment('pending,approved,denied');
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
