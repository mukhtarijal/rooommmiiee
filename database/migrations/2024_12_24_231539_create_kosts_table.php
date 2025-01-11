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
        Schema::create('kosts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->enum('gender', ['L', 'P']);
            $table->year('year_established');
            $table->string('room_size');
            $table->integer('capacity');
            $table->integer('available_rooms');
            $table->string('address');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 10, 8);
            $table->boolean('is_premium')->default(false);
            $table->enum('status', [
                'pending',
                'rejected',
                'approved',
                'incomplete'
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
        Schema::dropIfExists('kosts');
    }
};
