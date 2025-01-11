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
        Schema::create('sewas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kost_id')->constrained('kosts')->onDelete('cascade');
            $table->string('duration');
            $table->decimal('price', 10, 2);
            $table->string('promo_code')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('payment_proof')->nullable();
            $table->string('payment_forward')->nullable();
            $table->enum('status', [
                'pending',
                'approved',
                'cancelled',
                'payment_verified',
                'active',
                'expired'
            ])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewas');
    }
};
