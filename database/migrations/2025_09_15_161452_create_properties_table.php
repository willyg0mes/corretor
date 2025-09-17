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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained();
            $table->enum('type', ['venda', 'aluguel']);
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 15, 2);
            $table->string('currency', 3)->default('BRL');

            // Location
            $table->string('address');
            $table->string('neighborhood');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('country')->default('Brasil');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Property details
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('parking_spaces')->nullable();
            $table->integer('area')->nullable(); // m²
            $table->integer('land_area')->nullable(); // m² terreno
            $table->integer('floor')->nullable();
            $table->integer('total_floors')->nullable();

            // Features and amenities
            $table->json('features')->nullable(); // piscina, academia, etc.
            $table->json('amenities')->nullable(); // elevador, portaria, etc.

            // Status and visibility
            $table->enum('status', ['ativo', 'inativo', 'vendido', 'alugado'])->default('ativo');
            $table->boolean('featured')->default(false);
            $table->boolean('urgent')->default(false);
            $table->integer('views')->default(0);

            // SEO and search
            $table->string('slug')->unique();
            $table->text('seo_title')->nullable();
            $table->text('seo_description')->nullable();

            // Dates
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();

            // Indexes for performance
            $table->index(['type', 'status', 'featured']);
            $table->index(['city', 'state']);
            $table->index(['price']);
            $table->index(['published_at']);
            // Note: spatialIndex removed for SQLite compatibility - use PostgreSQL/MySQL in production
            // $table->spatialIndex(['latitude', 'longitude']); // For geographic queries

            // Note: fullText removed for SQLite compatibility - use PostgreSQL/MySQL in production
            // $table->fullText(['title', 'description', 'address', 'neighborhood', 'city']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
