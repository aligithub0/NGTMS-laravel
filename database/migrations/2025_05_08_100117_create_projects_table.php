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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status')->default(1); 
            $table->foreignId('project_type_id')->constrained('project_types');
            $table->foreignId('company_id')->constrained('companies');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignId('project_owner_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
