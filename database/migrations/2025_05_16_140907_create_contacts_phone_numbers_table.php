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
        Schema::create('contacts_phone_numbers', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('contact_id')->constrained('contacts');
            $table->string('phone_type', 50); 
            $table->string('phone_number', 20);
            $table->boolean('is_whatsapp')->default(0);
            $table->boolean('is_preferred')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts_phone_numbers');
    }
};
