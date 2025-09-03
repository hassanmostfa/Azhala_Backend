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
        Schema::create('chalet_service_assigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chalet_id')->constrained('chalets')->onDelete('cascade');
            $table->foreignId('chalet_service_id')->constrained('chalet_services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chalet_service_assigns');
    }
};
