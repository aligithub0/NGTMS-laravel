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
        Schema::create('ticket_journeys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            
  
            $table->foreignId('from_agent')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('to_agent')->nullable()->constrained('users')->onDelete('set null');
            

            $table->string('from_status', 50)->nullable();
            $table->string('to_status', 50)->nullable();
            
         
            $table->foreignId('actioned_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('logged_time')->useCurrent();
            $table->integer('total_time_diff')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_journeys');
    }
};
