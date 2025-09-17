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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['cliente', 'corretor', 'admin'])->default('cliente');
            $table->string('phone')->nullable();
            $table->string('creci')->nullable()->unique();
            $table->text('bio')->nullable();
            $table->json('preferences')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->string('avatar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'phone',
                'creci',
                'bio',
                'preferences',
                'is_active',
                'last_login_at',
                'avatar'
            ]);
        });
    }
};
