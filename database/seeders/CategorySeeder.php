<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Apartamento',
                'slug' => 'apartamento',
                'description' => 'Apartamentos residenciais em condomínios',
                'icon' => '🏢',
                'sort_order' => 1,
            ],
            [
                'name' => 'Casa',
                'slug' => 'casa',
                'description' => 'Casas residenciais térreas ou sobradadas',
                'icon' => '🏠',
                'sort_order' => 2,
            ],
            [
                'name' => 'Casa de Condomínio',
                'slug' => 'casa-condominio',
                'description' => 'Casas em condomínios fechados',
                'icon' => '🏘️',
                'sort_order' => 3,
            ],
            [
                'name' => 'Cobertura',
                'slug' => 'cobertura',
                'description' => 'Coberturas duplex ou triplex',
                'icon' => '🏙️',
                'sort_order' => 4,
            ],
            [
                'name' => 'Sala Comercial',
                'slug' => 'sala-comercial',
                'description' => 'Salas comerciais para escritórios',
                'icon' => '🏢',
                'sort_order' => 5,
            ],
            [
                'name' => 'Loja',
                'slug' => 'loja',
                'description' => 'Lojas em shopping centers ou ruas comerciais',
                'icon' => '🏪',
                'sort_order' => 6,
            ],
            [
                'name' => 'Galpão',
                'slug' => 'galpao',
                'description' => 'Galpões industriais e depósitos',
                'icon' => '🏭',
                'sort_order' => 7,
            ],
            [
                'name' => 'Terreno',
                'slug' => 'terreno',
                'description' => 'Terrenos urbanos e rurais',
                'icon' => '🌳',
                'sort_order' => 8,
            ],
            [
                'name' => 'Chácara',
                'slug' => 'chacara',
                'description' => 'Chácaras e sítios',
                'icon' => '🌾',
                'sort_order' => 9,
            ],
            [
                'name' => 'Prédio Inteiro',
                'slug' => 'predio-inteiro',
                'description' => 'Prédios comerciais completos',
                'icon' => '🏢',
                'sort_order' => 10,
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
