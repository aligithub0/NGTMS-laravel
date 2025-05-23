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
        Schema::create('tickets', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->foreignId('ticket_status_id')->constrained('ticket_statuses')->onDelete('cascade');
                $table->foreignId('created_by_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('assigned_to_id')->nullable()->constrained('users');
                $table->foreignId('ticket_source_id')->constrained('ticket_sources')->onDelete('cascade');
                $table->unsignedBigInteger('contact_id')->nullable();
                $table->string('contact_ref_no')->nullable();
                $table->foreignId('purpose_type_id')->constrained('purposes');
                $table->foreignId('SLA')->constrained('sla_configurations')->onDelete('cascade');
                $table->time('resolution_time')->nullable();
                $table->time('response_time')->nullable();
                $table->foreignId('notification_type_id')->constrained('notification_types');
                $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
                $table->boolean('reminder_flag')->default(false);
                $table->dateTime('reminder_datetime')->nullable();
                $table->timestamps();
            });
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
