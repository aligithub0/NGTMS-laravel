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
        Schema::create('contacts_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('contacts');
            $table->char('whatsapp_pref', 1)->nullable(); 
            $table->char('mailing_address_pref', 1)->nullable(); 
            $table->string('language_pref', 50)->nullable();
            $table->boolean('email_opt_in')->default(1);
            $table->boolean('whatsapp_opt_in')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts_preferences');
    }
};
