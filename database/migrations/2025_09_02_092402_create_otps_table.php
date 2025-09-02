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
        Schema::create('otps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('otp_code');
            $table->string('otp_type'); // email, sms, etc.
            $table->string('otp_mode'); // verification, reset, etc.
            $table->string('user_identifier'); // email or phone
            $table->string('phone_code')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('expires_at');
            $table->boolean('is_used')->default(false);
            $table->string('generated_by_ip')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
