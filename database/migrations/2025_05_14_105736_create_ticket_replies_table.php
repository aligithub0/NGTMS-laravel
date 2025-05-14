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
        Schema::create('ticket_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->foreignId('replied_by_user_id')->constrained('users')->onDelete('cascade');
            $table->string('subject');
            $table->text('message');
            $table->foreignId('priority_type_id')->constrained('priorities')->onDelete('cascade');
            $table->string('reply_type');
            $table->string('attachment_path')->nullable();
            $table->text('internal_notes')->nullable();
            $table->text('external_notes')->nullable();
            $table->boolean('is_desc_send_to_contact')->default(0);
            $table->string('status_after_reply')->nullable();
            $table->string('contact_id')->nullable();
            $table->string('contact_ref_no')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('to_recipients')->nullable();
            $table->text('cc_recipients')->nullable();
            $table->boolean('is_reply_from_contact')->default(0);
            $table->boolean('is_contact_notify')->default(1);
            $table->text('activity_log')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_replies');
    }
};
