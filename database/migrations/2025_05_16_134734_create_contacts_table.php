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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id(); 
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('status')->default(1); 
            
            $table->foreignId('contact_type_id')->nullable()->constrained('contact_types');
            $table->foreignId('designation_id')->nullable()->constrained('designations');

            $table->string('preferred_contact_method', 50)->nullable();
            $table->string('contact_priority', 50)->nullable();
            $table->string('time_zone', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('picture_url')->nullable();
            $table->string('country')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
