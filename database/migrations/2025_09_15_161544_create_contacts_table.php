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
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade'); // cliente
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade'); // corretor
            $table->string('subject');
            $table->text('message');
            $table->enum('status', ['sent', 'read', 'replied', 'archived'])->default('sent');
            $table->json('contact_info')->nullable(); // phone, email, etc.
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['sender_id', 'status']);
            $table->index(['receiver_id', 'status']);
            $table->index(['property_id']);
            $table->index(['status', 'created_at']);
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
