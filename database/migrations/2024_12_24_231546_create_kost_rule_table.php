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
        Schema::create('kost_rule', function (Blueprint $table) {
            $table->foreignId('kost_id')->constrained('kosts')->onDelete('cascade');
            $table->foreignId('rule_id')->constrained('rules')->onDelete('cascade');
            $table->timestamps();

            $table->primary(['kost_id', 'rule_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kost_rule');
    }
};
