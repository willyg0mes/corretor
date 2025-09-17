<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        \App\Models\User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@corretor.com',
            'role' => 'admin',
            'phone' => '(11) 99999-0001',
            'email_verified_at' => now(),
        ]);

        // Corretor Principal
        \App\Models\User::factory()->create([
            'name' => 'Jieson Alaor',
            'email' => 'jieson.corretor@corretor.com',
            'role' => 'corretor',
            'creci' => '42090',
            'phone' => '+55 62 9464-0321',
            'bio' => 'Corretor especializado em imóveis residenciais e comerciais. Experiência comprovada no mercado imobiliário.',
            'email_verified_at' => now(),
        ]);

        // Clientes
        \App\Models\User::factory()->create([
            'name' => 'Ana Pereira',
            'email' => 'ana.cliente@corretor.com',
            'role' => 'cliente',
            'phone' => '(11) 99999-0005',
            'bio' => 'Buscando apartamento de 2 quartos próximo ao metrô.',
            'email_verified_at' => now(),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Roberto Costa',
            'email' => 'roberto.cliente@corretor.com',
            'role' => 'cliente',
            'phone' => '(11) 99999-0006',
            'bio' => 'Interessado em casas com jardim na zona norte.',
            'email_verified_at' => now(),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Fernanda Lima',
            'email' => 'fernanda.cliente@corretor.com',
            'role' => 'cliente',
            'phone' => '(11) 99999-0007',
            'bio' => 'Procurando imóvel comercial para abrir meu negócio.',
            'email_verified_at' => now(),
        ]);

        // Mais usuários de teste (10 ao total por role)
        \App\Models\User::factory(5)->create(['role' => 'corretor']);
        \App\Models\User::factory(10)->create(['role' => 'cliente']);
    }
}
