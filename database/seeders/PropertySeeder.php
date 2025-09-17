<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyVideo;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar corretor principal e categorias
        $corretorPrincipal = User::where('role', 'corretor')->where('name', 'Jieson Alaor')->first();
        if (!$corretorPrincipal) {
            // Criar o corretor principal se não existir
            $corretorPrincipal = User::factory()->create([
                'name' => 'Jieson Alaor',
                'email' => 'jieson.corretor@corretor.com',
                'role' => 'corretor',
                'creci' => '42090',
                'phone' => '+55 62 9464-0321',
                'bio' => 'Corretor especializado em imóveis residenciais e comerciais. Experiência comprovada no mercado imobiliário.',
                'email_verified_at' => now(),
            ]);
        }
        $categories = Category::all();

        $properties = [
            // APARTAMENTOS
            [
                'title' => 'Apartamento 2 Quartos - Vila Madalena',
                'description' => 'Apartamento reformado de 2 quartos e 1 suíte, localizado no coração da Vila Madalena. Excelente localização, próximo ao metrô e comércios. Possui sala ampla, cozinha americana, varanda gourmet e vaga de garagem. Prédio com portaria 24h e elevador.',
                'price' => 850000.00,
                'type' => 'venda',
                'category_slug' => 'apartamento',
                'address' => 'Rua Harmonia, 1234',
                'neighborhood' => 'Vila Madalena',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '05435-001',
                'latitude' => -23.5505,
                'longitude' => -46.6333,
                'bedrooms' => 2,
                'bathrooms' => 2,
                'parking_spaces' => 1,
                'area' => 85,
                'features' => ['Ar condicionado', 'Mobiliado', 'Vista para rua'],
                'amenities' => ['Elevador', 'Portaria 24h', 'Varanda gourmet'],
                'status' => 'ativo',
                'featured' => true,
                'urgent' => false,
                'published_at' => now(),
                'images' => [
                    'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=800&h=600&fit=crop',
                ]
            ],
            [
                'title' => 'Apartamento 3 Quartos - Jardins',
                'description' => 'Luxuoso apartamento de 3 quartos com suíte master, localizado no nobre bairro dos Jardins. Acabamento de alto padrão, piso em porcelanato, cozinha planejada com eletrodomésticos embutidos. Sala de jantar, sala de estar, lavanderia e 2 vagas de garagem.',
                'price' => 2200000.00,
                'type' => 'venda',
                'category_slug' => 'apartamento',
                'address' => 'Alameda Campinas, 567',
                'neighborhood' => 'Jardins',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '01404-000',
                'latitude' => -23.5667,
                'longitude' => -46.6833,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'parking_spaces' => 2,
                'area' => 120,
                'features' => ['Suíte master', 'Cozinha planejada', 'Área de serviço', 'Piscina privativa', 'Terraço'],
                'amenities' => ['Elevador', 'Portaria 24h', 'Salão de festas', 'Academia', 'Piscina'],
                'status' => 'ativo',
                'featured' => true,
                'urgent' => true,
                'published_at' => now(),
                'images' => [
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800&h=600&fit=crop',
                ],
                'videos' => [
                    [
                        'url' => 'https://sample-videos.com/zip/10/mp4/SampleVideo_1280x720_1mb.mp4',
                        'title' => 'Tour Virtual - Sala de Estar e Cozinha',
                        'description' => 'Conheça a sala integrada com cozinha americana',
                        'thumbnail' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=400&h=300&fit=crop',
                        'duration' => 45
                    ]
                ]
            ],

            // CASAS
            [
                'title' => 'Casa 3 Quartos - Moema',
                'description' => 'Casa térrea de 3 quartos, sendo 2 suítes, localizada em rua tranquila do bairro Moema. Possui sala integrada com cozinha americana, lavanderia, quintal com churrasqueira e 2 vagas de garagem. Pronta para morar.',
                'price' => 1800000.00,
                'type' => 'venda',
                'category_slug' => 'casa',
                'address' => 'Rua Gaivota, 890',
                'neighborhood' => 'Moema',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '04083-051',
                'latitude' => -23.6000,
                'longitude' => -46.6500,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'parking_spaces' => 2,
                'area' => 150,
                'features' => ['Quintal', 'Churrasqueira', 'Cozinha americana', 'Piscina privativa'],
                'amenities' => ['Condomínio fechado', 'Segurança 24h'],
                'status' => 'ativo',
                'featured' => true,
                'urgent' => false,
                'published_at' => now(),
                'images' => [
                    'https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&h=600&fit=crop',
                ],
                'videos' => [
                    [
                        'url' => 'https://sample-videos.com/zip/10/mp4/SampleVideo_1280x720_2mb.mp4',
                        'title' => 'Tour Completo da Casa',
                        'description' => 'Visite todos os ambientes desta casa incrível',
                        'thumbnail' => 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=400&h=300&fit=crop',
                        'duration' => 120
                    ]
                ]
            ],
            [
                'title' => 'Casa 4 Quartos - Alphaville',
                'description' => 'Casa sobrado de 4 quartos com 3 suítes, localizada em condomínio fechado de Alphaville. Possui sala de estar, sala de jantar, cozinha gourmet, lavanderia, escritório, quintal com piscina e 3 vagas de garagem. Área total de 400m².',
                'price' => 3200000.00,
                'type' => 'venda',
                'category_slug' => 'casa',
                'address' => 'Alameda Rio Negro, 1234',
                'neighborhood' => 'Alphaville',
                'city' => 'Barueri',
                'state' => 'SP',
                'zip_code' => '06454-000',
                'latitude' => -23.5167,
                'longitude' => -46.8500,
                'bedrooms' => 4,
                'bathrooms' => 4,
                'parking_spaces' => 3,
                'area' => 400,
                'land_area' => 600,
                'features' => ['Piscina', 'Escritório', 'Cozinha gourmet', 'Terraço', 'Churrasqueira'],
                'amenities' => ['Condomínio fechado', 'Segurança 24h', 'Piscina', 'Quadra poliesportiva', 'Playground'],
                'status' => 'ativo',
                'featured' => false,
                'urgent' => true,
                'published_at' => now(),
                'images' => [
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=800&h=600&fit=crop',
                ]
            ],

            // CASAS DE CONDOMÍNIO
            [
                'title' => 'Casa de Condomínio - Riviera de São Lourenço',
                'description' => 'Casa de 3 quartos com 2 suítes em condomínio fechado. Possui sala integrada, cozinha americana, área de serviço, quintal com churrasqueira e 2 vagas de garagem. Condomínio com infraestrutura completa.',
                'price' => 950000.00,
                'type' => 'venda',
                'category_slug' => 'casa-condominio',
                'address' => 'Rua das Flores, 456',
                'neighborhood' => 'Riviera de São Lourenço',
                'city' => 'Bertioga',
                'state' => 'SP',
                'zip_code' => '11250-000',
                'latitude' => -23.8500,
                'longitude' => -46.1333,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'parking_spaces' => 2,
                'area' => 180,
                'land_area' => 250,
                'features' => ['Quintal', 'Churrasqueira', 'Área de serviço', 'Piscina privativa'],
                'amenities' => ['Condomínio fechado', 'Piscina', 'Quadra poliesportiva', 'Playground', 'Academia'],
                'status' => 'ativo',
                'featured' => true,
                'urgent' => false,
                'published_at' => now(),
                'images' => [
                    'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800&h=600&fit=crop',
                ]
            ],

            // COBERTURAS
            [
                'title' => 'Cobertura Duplex - Faria Lima',
                'description' => 'Cobertura duplex de 4 quartos com 3 suítes, localizada na Faria Lima. Possui 2 salas, cozinha gourmet, área de serviço, terraço com vista panorâmica, piscina privativa e 3 vagas de garagem. Acabamento de luxo.',
                'price' => 5800000.00,
                'type' => 'venda',
                'category_slug' => 'cobertura',
                'address' => 'Av. Brigadeiro Faria Lima, 2345',
                'neighborhood' => 'Itaim Bibi',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '01452-000',
                'latitude' => -23.5833,
                'longitude' => -46.6833,
                'bedrooms' => 4,
                'bathrooms' => 4,
                'parking_spaces' => 3,
                'area' => 280,
                'features' => ['Terraço', 'Piscina privativa', 'Vista panorâmica', 'Duplex', 'Cozinha gourmet', 'Suíte master'],
                'amenities' => ['Elevador', 'Portaria 24h', 'Salão de festas', 'Heliponto', 'Academia', 'Piscina'],
                'status' => 'ativo',
                'featured' => true,
                'urgent' => true,
                'published_at' => now(),
                'images' => [
                    'https://images.unsplash.com/photo-1600607687644-c7171b42498b?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1600566753151-384129cf4e3e?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?w=800&h=600&fit=crop',
                ]
            ],

            // SALAS COMERCIAIS
            [
                'title' => 'Sala Comercial - Vila Olímpia',
                'description' => 'Sala comercial de 120m² no centro empresarial da Vila Olímpia. Possui 3 salas privativas, copa, banheiro social, ar condicionado central, piso elevado e infraestrutura para TI. Prédio com elevador e segurança 24h.',
                'price' => 1500000.00,
                'type' => 'venda',
                'category_slug' => 'sala-comercial',
                'address' => 'Rua Fidêncio Ramos, 308',
                'neighborhood' => 'Vila Olímpia',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '04551-010',
                'latitude' => -23.6000,
                'longitude' => -46.6833,
                'bedrooms' => null,
                'bathrooms' => 2,
                'parking_spaces' => 4,
                'area' => 120,
                'features' => ['Ar condicionado central', 'Piso elevado', 'Infraestrutura TI'],
                'amenities' => ['Elevador', 'Segurança 24h', 'Estacionamento'],
                'status' => 'ativo',
                'featured' => false,
                'urgent' => false,
                'published_at' => now(),
                'images' => [
                    'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=800&h=600&fit=crop',
                ]
            ],

            // LOJAS
            [
                'title' => 'Loja 200m² - Rua 25 de Março',
                'description' => 'Loja comercial de 200m² na tradicional Rua 25 de Março, coração do comércio popular de São Paulo. Possui mezanino, banheiro, depósito e fachada ampla. Excelente localização com alto fluxo de pessoas.',
                'price' => 2800000.00,
                'type' => 'venda',
                'category_slug' => 'loja',
                'address' => 'Rua 25 de Março, 987',
                'neighborhood' => 'Centro',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '01000-000',
                'latitude' => -23.5500,
                'longitude' => -46.6333,
                'bedrooms' => null,
                'bathrooms' => 2,
                'parking_spaces' => 0,
                'area' => 200,
                'features' => ['Mezanino', 'Fachada ampla', 'Depósito'],
                'amenities' => [],
                'status' => 'ativo',
                'featured' => true,
                'urgent' => false,
                'published_at' => now(),
                'images' => [
                    'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&h=600&fit=crop',
                ]
            ],

            // GALPÕES
            [
                'title' => 'Galpão Industrial 1000m² - Distrito Industrial',
                'description' => 'Galpão industrial de 1000m² em distrito industrial, com laje de 10 toneladas, portão basculante, escritório administrativo, vestiários e refeitório. Possui 10 vagas de caminhão e localização estratégica.',
                'price' => 4500000.00,
                'type' => 'venda',
                'category_slug' => 'galpao',
                'address' => 'Rodovia Anhanguera, km 23',
                'neighborhood' => 'Distrito Industrial',
                'city' => 'Jundiaí',
                'state' => 'SP',
                'zip_code' => '13200-000',
                'latitude' => -23.1833,
                'longitude' => -46.8833,
                'bedrooms' => null,
                'bathrooms' => 4,
                'parking_spaces' => 10,
                'area' => 1000,
                'features' => ['Laje 10t', 'Portão basculante', 'Escritório administrativo'],
                'amenities' => ['Vestiários', 'Refeitório', 'Segurança 24h'],
                'status' => 'ativo',
                'featured' => false,
                'urgent' => false,
                'published_at' => now(),
                'images' => [
                    'https://images.unsplash.com/photo-1582407947304-a55c9295784f?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1581092921461-eab62e97a780?w=800&h=600&fit=crop',
                ]
            ],

            // TERRENOS
            [
                'title' => 'Terreno 500m² - Zona Norte',
                'description' => 'Terreno plano de 500m² em zona residencial da zona norte de São Paulo. Possui frente de 20m, profundidade de 25m, infraestrutura completa (água, luz, esgoto) e localização privilegiada próximo ao metrô.',
                'price' => 800000.00,
                'type' => 'venda',
                'category_slug' => 'terreno',
                'address' => 'Rua do Norte, 1500',
                'neighborhood' => 'Santana',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '02000-000',
                'latitude' => -23.5000,
                'longitude' => -46.6167,
                'bedrooms' => null,
                'bathrooms' => null,
                'parking_spaces' => null,
                'area' => null,
                'land_area' => 500,
                'features' => ['Terreno plano', 'Infraestrutura completa', 'Próximo ao metrô'],
                'amenities' => [],
                'status' => 'ativo',
                'featured' => false,
                'urgent' => false,
                'published_at' => now(),
                'images' => [
                    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=800&h=600&fit=crop',
                ]
            ],

            // CHÁCARAS
            [
                'title' => 'Chácara 2 hectares - Interior de SP',
                'description' => 'Chácara de 2 hectares com casa de 200m², pomar, curral para animais, lago, mata nativa preservada e nascente de água. Localizada em estrada asfaltada, com energia elétrica e internet. Ideal para lazer ou produção.',
                'price' => 1200000.00,
                'type' => 'venda',
                'category_slug' => 'chacara',
                'address' => 'Estrada Municipal SP-123, km 15',
                'neighborhood' => 'Zona Rural',
                'city' => 'Pirapora do Bom Jesus',
                'state' => 'SP',
                'zip_code' => '06500-000',
                'latitude' => -23.4000,
                'longitude' => -47.0000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'parking_spaces' => 4,
                'area' => 200,
                'land_area' => 20000,
                'features' => ['Pomar', 'Lago', 'Curral', 'Nascente', 'Churrasqueira', 'Quintal'],
                'amenities' => ['Energia elétrica', 'Internet', 'Estrada asfaltada'],
                'status' => 'ativo',
                'featured' => true,
                'urgent' => false,
                'published_at' => now(),
                'images' => [
                    'https://images.unsplash.com/photo-1449844908441-8829872d2607?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=800&h=600&fit=crop',
                ]
            ],

            // PRÉDIO INTEIRO
            [
                'title' => 'Prédio Comercial 5 Andares - Centro',
                'description' => 'Prédio comercial de 5 andares com 800m² por andar, localizado no centro financeiro de São Paulo. Possui elevadores, sistema de ar condicionado central, infraestrutura para TI, 20 vagas de garagem e portaria 24h.',
                'price' => 15000000.00,
                'type' => 'venda',
                'category_slug' => 'predio-inteiro',
                'address' => 'Rua Boa Vista, 234',
                'neighborhood' => 'Centro',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '01000-000',
                'latitude' => -23.5500,
                'longitude' => -46.6333,
                'bedrooms' => null,
                'bathrooms' => 10,
                'parking_spaces' => 20,
                'area' => 4000,
                'features' => ['Ar condicionado central', 'Infraestrutura TI', 'Elevadores'],
                'amenities' => ['Portaria 24h', 'Estacionamento', 'Sistema de segurança'],
                'status' => 'ativo',
                'featured' => true,
                'urgent' => true,
                'published_at' => now(),
                'images' => [
                    'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=800&h=600&fit=crop',
                ]
            ],

            // IMÓVEIS DE GOIÁS
            [
                'title' => 'Casa 3 Quartos - Alexânia',
                'description' => 'Casa residencial de 3 quartos com suíte, localizada em Alexânia-GO. Área construída de 180m² em terreno de 500m². Sala de estar, sala de jantar, cozinha americana, banheiro social, 3 quartos (sendo 1 suíte), lavanderia e quintal. Pronta para morar.',
                'price' => 350000.00,
                'type' => 'venda',
                'category_slug' => 'casa',
                'address' => 'Rua das Flores, 123',
                'neighborhood' => 'Centro',
                'city' => 'Alexânia',
                'state' => 'GO',
                'zip_code' => '72920-000',
                'latitude' => -16.0833,
                'longitude' => -48.5075,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'parking_spaces' => 2,
                'area' => 180,
                'land_area' => 500,
                'features' => ['Suíte master', 'Cozinha americana', 'Quintal', 'Lavanderia'],
                'amenities' => ['Energia elétrica', 'Água encanada', 'Asfalto'],
                'status' => 'ativo',
                'featured' => true,
                'urgent' => false,
                'published_at' => now(),
                'images' => [
                    'https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1583608205776-bfd35f0d9f83?w=800&h=600&fit=crop',
                ]
            ],
            [
                'title' => 'Apartamento 2 Quartos - Goiânia',
                'description' => 'Apartamento moderno de 2 quartos no Setor Bueno, Goiânia. 75m² de área privativa, sala conjugada com cozinha americana, 2 quartos (1 suíte), banheiro social, varanda e vaga de garagem. Prédio com elevador, portaria 24h e área de lazer.',
                'price' => 280000.00,
                'type' => 'venda',
                'category_slug' => 'apartamento',
                'address' => 'Av. T-9, 456',
                'neighborhood' => 'Setor Bueno',
                'city' => 'Goiânia',
                'state' => 'GO',
                'zip_code' => '74140-020',
                'latitude' => -16.6869,
                'longitude' => -49.2648,
                'bedrooms' => 2,
                'bathrooms' => 1,
                'parking_spaces' => 1,
                'area' => 75,
                'features' => ['Suíte master', 'Cozinha americana', 'Varanda'],
                'amenities' => ['Elevador', 'Portaria 24h', 'Área de lazer', 'Piscina'],
                'status' => 'ativo',
                'featured' => false,
                'urgent' => false,
                'published_at' => now(),
                'images' => [
                    'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1484154218962-a197022b5858?w=800&h=600&fit=crop',
                ]
            ],
            [
                'title' => 'Casa 4 Quartos - Aparecida de Goiânia',
                'description' => 'Casa residencial de 4 quartos em condomínio fechado em Aparecida de Goiânia. 250m² construídos em terreno de 600m². Sala ampla, cozinha planejada, 4 quartos (2 suítes), 3 banheiros, lavanderia, piscina privativa e churrasqueira. Condomínio com segurança 24h.',
                'price' => 550000.00,
                'type' => 'venda',
                'category_slug' => 'casa',
                'address' => 'Rua dos Ipês, 789',
                'neighborhood' => 'Residencial Village',
                'city' => 'Aparecida de Goiânia',
                'state' => 'GO',
                'zip_code' => '74935-230',
                'latitude' => -16.8194,
                'longitude' => -49.2469,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'parking_spaces' => 2,
                'area' => 250,
                'land_area' => 600,
                'features' => ['Suíte master', 'Cozinha planejada', 'Piscina privativa', 'Churrasqueira', 'Lavanderia'],
                'amenities' => ['Condomínio fechado', 'Segurança 24h', 'Área verde', 'Playground'],
                'status' => 'ativo',
                'featured' => true,
                'urgent' => false,
                'published_at' => now(),
                'images' => [
                    'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1449844908441-8829872d2607?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1505843513577-22bb7d21e455?w=800&h=600&fit=crop',
                ]
            ],
            [
                'title' => 'Terreno 1000m² - Anápolis',
                'description' => 'Terreno plano de 1000m² em Anápolis-GO, excelente localização próxima ao centro. Terreno retangular, esquina, com frente para duas ruas. Infraestrutura completa (água, luz, esgoto). Ideal para construção residencial ou comercial.',
                'price' => 180000.00,
                'type' => 'venda',
                'category_slug' => 'terreno',
                'address' => 'Rua do Comércio, esquina com Av. Brasil',
                'neighborhood' => 'Centro',
                'city' => 'Anápolis',
                'state' => 'GO',
                'zip_code' => '75110-030',
                'latitude' => -16.3285,
                'longitude' => -48.9534,
                'bedrooms' => null,
                'bathrooms' => null,
                'parking_spaces' => null,
                'area' => null,
                'land_area' => 1000,
                'features' => ['Esquina', 'Terreno plano', 'Infraestrutura completa'],
                'amenities' => ['Energia elétrica', 'Água encanada', 'Esgoto', 'Asfalto'],
                'status' => 'ativo',
                'featured' => false,
                'urgent' => true,
                'published_at' => now(),
                'images' => [
                    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1582407947304-fd86f028f716?w=800&h=600&fit=crop',
                    'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=800&h=600&fit=crop',
                ]
            ],
        ];

        // Criar propriedades
        foreach ($properties as $propertyData) {
            $corretor = $corretorPrincipal;
            $category = $categories->where('slug', $propertyData['category_slug'])->first();

            if (!$category) {
                continue; // Pular se categoria não existir
            }

            // Criar slug único
            $slug = Str::slug($propertyData['title']);
            $originalSlug = $slug;
            $counter = 1;
            while (Property::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $property = Property::create([
                'user_id' => $corretor->id,
                'category_id' => $category->id,
                'title' => $propertyData['title'],
                'slug' => $slug,
                'description' => $propertyData['description'],
                'price' => $propertyData['price'],
                'currency' => 'BRL',
                'type' => $propertyData['type'],
                'address' => $propertyData['address'],
                'neighborhood' => $propertyData['neighborhood'],
                'city' => $propertyData['city'],
                'state' => $propertyData['state'],
                'zip_code' => $propertyData['zip_code'],
                'country' => 'Brasil',
                'latitude' => $propertyData['latitude'],
                'longitude' => $propertyData['longitude'],
                'bedrooms' => $propertyData['bedrooms'],
                'bathrooms' => $propertyData['bathrooms'],
                'parking_spaces' => $propertyData['parking_spaces'],
                'area' => $propertyData['area'],
                'land_area' => $propertyData['land_area'] ?? null,
                'features' => $propertyData['features'],
                'amenities' => $propertyData['amenities'],
                'status' => $propertyData['status'],
                'featured' => $propertyData['featured'],
                'urgent' => $propertyData['urgent'],
                'published_at' => $propertyData['published_at'],
                'seo_title' => $propertyData['title'],
                'seo_description' => Str::limit(strip_tags($propertyData['description']), 160),
            ]);

            // Criar imagens para a propriedade
            if (isset($propertyData['images'])) {
                foreach ($propertyData['images'] as $index => $imageUrl) {
                    PropertyImage::create([
                        'property_id' => $property->id,
                        'filename' => 'property-' . $property->id . '-image-' . ($index + 1) . '.jpg',
                        'original_filename' => 'property-' . $property->id . '-image-' . ($index + 1) . '.jpg',
                        'path' => $imageUrl, // Usar URL externa para demonstração
                        'disk' => 'external',
                        'mime_type' => 'image/jpeg',
                        'size' => rand(100000, 500000), // Tamanho simulado
                        'dimensions' => json_encode(['width' => 800, 'height' => 600]),
                        'alt_text' => $property->title . ' - Imagem ' . ($index + 1),
                        'sort_order' => $index,
                        'is_featured' => $index === 0,
                    ]);
                }
            }

            // Criar vídeos para alguns imóveis (demonstração)
            if (isset($propertyData['videos']) && !empty($propertyData['videos'])) {
                foreach ($propertyData['videos'] as $index => $videoData) {
                    PropertyVideo::create([
                        'property_id' => $property->id,
                        'filename' => 'property-' . $property->id . '-video-' . ($index + 1) . '.mp4',
                        'original_filename' => $videoData['title'] . '.mp4',
                        'path' => $videoData['url'],
                        'disk' => 'external',
                        'mime_type' => 'video/mp4',
                        'size' => rand(5000000, 20000000), // Tamanho simulado
                        'duration' => $videoData['duration'] ?? rand(60, 300),
                        'dimensions' => json_encode(['width' => 1920, 'height' => 1080]),
                        'thumbnail_path' => $videoData['thumbnail'],
                        'alt_text' => $videoData['title'],
                        'caption' => $videoData['description'] ?? null,
                        'sort_order' => 100 + $index, // Vídeos vêm depois das imagens
                        'is_featured' => $index === 0,
                        'processing_status' => 'completed',
                    ]);
                }
            }

            // Incrementar contador de visualizações para simular atividade
            $property->increment('views', rand(5, 50));
        }
    }
}
