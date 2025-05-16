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
        Schema::create('contacts_social_links', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('contact_id')->constrained('contacts');
            $table->string('platform', 50)->nullable(); 
            $table->string('handle', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts_social_links');
    }
};
