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
        Schema::create('sla_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('purpose_id')->constrained('purposes');
            $table->time('response_time'); 
            $table->time('resolution_time'); 
            $table->foreignId('escalated_to_user_id')->constrained('users');
            $table->timestamps();
        });
    } 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sla_configurations');
    }
};
