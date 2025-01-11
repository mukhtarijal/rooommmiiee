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
        Schema::create('kost_advertisements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kost_id')->constrained('kosts')->onDelete('cascade');
            $table->string('promo_code')->nullable();
            $table->enum('promo_type', ['percentage', 'fixed'])->nullable();
            $table->decimal('promo_value', 12, 2)->nullable();
            $table->foreignId('advertisement_duration_id')->constrained('advertisement_durations')->onDelete('cascade');
            $table->decimal('price', 12, 2);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('promotional_photo')->nullable();
            $table->string('payment_proof')->nullable();
            $table->enum('status', [
                'pending',
                'cancelled',
                'awaiting_payment',
                'active',
                'expired'
            ])->default('awaiting_payment');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kost_advertisements');
    }
};
