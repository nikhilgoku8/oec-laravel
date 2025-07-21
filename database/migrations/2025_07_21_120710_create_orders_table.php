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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_ref_id');
            $table->string('billing_fname', 50);
            $table->string('billing_lname', 50);
            $table->string('billing_email');
            $table->string('billing_phone', 20)->nullable();
            $table->string('billing_company')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_city', 100)->nullable();
            $table->string('billing_state', 50)->nullable();
            $table->string('billing_country', 60);
            $table->string('billing_postcode', 20)->nullable();
            $table->text('enquiry_notes')->nullable();
            $table->string('status', 16)->default('pending')->comment('pending,completed,denied');
            $table->text('admin_remark')->nullable();
            $table->string('created_by', 50);
            $table->string('updated_by', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
