@extends('layouts.app')

@section('title', 'Buscar Imóveis - Corretor Imóveis')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="{ showFilters: false, viewMode: '{{ request('view', 'grid') }}' }">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Anúncios de Imóveis</h1>
                    <p class="text-gray-600 mt-1">{{ $properties->total() }} anúncios encontrados</p>
                </div>

                <!-- Mobile Filters Toggle & View Controls -->
                <div class="flex items-center space-x-2 lg:space-x-4">
                    <!-- Mobile Filters Button -->
                    <button @click="showFilters = !showFilters"
                            class="lg:hidden bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        <span>Filtros</span>
                    </button>

                    @auth
                        @if(auth()->user()->isCorretor())
                            <a href="{{ route('properties.create') }}"
                               class="hidden sm:inline-flex bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Anunciar</span>
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-1/4"
                 x-show="showFilters || window.innerWidth >= 1024"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform -translate-x-4">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtros</h3>

                    <form action="{{ route('properties.index.public') }}" method="GET" class="space-y-4">
                        <!-- Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                            <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Todos</option>
                                <option value="venda" {{ request('type') === 'venda' ? 'selected' : '' }}>Venda</option>
                                <option value="aluguel" {{ request('type') === 'aluguel' ? 'selected' : '' }}>Aluguel</option>
                            </select>
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                            <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Todas as categorias</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cidade</label>
                            <select name="city" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Todas as cidades</option>
                                @foreach($availableCities as $city)
                                    <option value="{{ $city }}" {{ request('city', 'Alexânia') === $city ? 'selected' : '' }}>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                            <select name="state" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="GO" {{ request('state', 'GO') === 'GO' ? 'selected' : '' }}>Goiás</option>
                                <option value="AC" {{ request('state') === 'AC' ? 'selected' : '' }}>Acre</option>
                                <option value="AL" {{ request('state') === 'AL' ? 'selected' : '' }}>Alagoas</option>
                                <option value="AP" {{ request('state') === 'AP' ? 'selected' : '' }}>Amapá</option>
                                <option value="AM" {{ request('state') === 'AM' ? 'selected' : '' }}>Amazonas</option>
                                <option value="BA" {{ request('state') === 'BA' ? 'selected' : '' }}>Bahia</option>
                                <option value="CE" {{ request('state') === 'CE' ? 'selected' : '' }}>Ceará</option>
                                <option value="DF" {{ request('state') === 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                                <option value="ES" {{ request('state') === 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                                <option value="MA" {{ request('state') === 'MA' ? 'selected' : '' }}>Maranhão</option>
                                <option value="MT" {{ request('state') === 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                                <option value="MS" {{ request('state') === 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                                <option value="MG" {{ request('state') === 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                                <option value="PA" {{ request('state') === 'PA' ? 'selected' : '' }}>Pará</option>
                                <option value="PB" {{ request('state') === 'PB' ? 'selected' : '' }}>Paraíba</option>
                                <option value="PR" {{ request('state') === 'PR' ? 'selected' : '' }}>Paraná</option>
                                <option value="PE" {{ request('state') === 'PE' ? 'selected' : '' }}>Pernambuco</option>
                                <option value="PI" {{ request('state') === 'PI' ? 'selected' : '' }}>Piauí</option>
                                <option value="RJ" {{ request('state') === 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                                <option value="RN" {{ request('state') === 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                                <option value="RS" {{ request('state') === 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                                <option value="RO" {{ request('state') === 'RO' ? 'selected' : '' }}>Rondônia</option>
                                <option value="RR" {{ request('state') === 'RR' ? 'selected' : '' }}>Roraima</option>
                                <option value="SC" {{ request('state') === 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                                <option value="SP" {{ request('state') === 'SP' ? 'selected' : '' }}>São Paulo</option>
                                <option value="SE" {{ request('state') === 'SE' ? 'selected' : '' }}>Sergipe</option>
                                <option value="TO" {{ request('state') === 'TO' ? 'selected' : '' }}>Tocantins</option>
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Faixa de Preço</label>
                            <div class="flex space-x-2">
                                <input type="number" name="min_price" value="{{ request('min_price') }}"
                                       placeholder="Mín"
                                       class="w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <input type="number" name="max_price" value="{{ request('max_price') }}"
                                       placeholder="Máx"
                                       class="w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Bedrooms -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quartos (mínimo)</label>
                            <select name="bedrooms" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Qualquer</option>
                                <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1+</option>
                                <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2+</option>
                                <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3+</option>
                                <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4+</option>
                            </select>
                        </div>

                        <!-- Bathrooms -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Banheiros (mínimo)</label>
                            <select name="bathrooms" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Qualquer</option>
                                <option value="1" {{ request('bathrooms') == '1' ? 'selected' : '' }}>1+</option>
                                <option value="2" {{ request('bathrooms') == '2' ? 'selected' : '' }}>2+</option>
                                <option value="3" {{ request('bathrooms') == '3' ? 'selected' : '' }}>3+</option>
                            </select>
                        </div>

                        <!-- Special Filters -->
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="featured" value="1" {{ request('featured') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Apenas destaque</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="urgent" value="1" {{ request('urgent') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Apenas urgente</span>
                            </label>
                        </div>

                        <!-- Features & Amenities -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Características</label>

                            <!-- Features -->
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-600 mb-2">Comodidades Internas</h4>
                                <div class="space-y-2">
                                    @php
                                        $availableFeatures = [
                                            'Ar condicionado' => 'Ar condicionado',
                                            'Mobiliado' => 'Mobiliado',
                                            'Suíte master' => 'Suíte master',
                                            'Vista para rua' => 'Vista para rua',
                                            'Cozinha planejada' => 'Cozinha planejada',
                                            'Área de serviço' => 'Área de serviço',
                                            'Escritório' => 'Escritório',
                                            'Terraço' => 'Terraço',
                                            'Piscina privativa' => 'Piscina privativa',
                                            'Churrasqueira' => 'Churrasqueira',
                                            'Quintal' => 'Quintal',
                                            'Cozinha americana' => 'Cozinha americana',
                                            'Pomar' => 'Pomar',
                                            'Curral' => 'Curral',
                                            'Lago' => 'Lago',
                                            'Nascente' => 'Nascente',
                                            'Duplex' => 'Duplex',
                                            'Laje 10t' => 'Laje 10t',
                                            'Portão basculante' => 'Portão basculante',
                                            'Mezanino' => 'Mezanino',
                                            'Infraestrutura TI' => 'Infraestrutura TI',
                                        ];
                                    @endphp

                                    @foreach($availableFeatures as $value => $label)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="features[]" value="{{ $value }}"
                                                   {{ in_array($value, request('features', [])) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                            <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Amenities -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-600 mb-2">Comodidades do Condomínio</h4>
                                <div class="space-y-2">
                                    @php
                                        $availableAmenities = [
                                            'Elevador' => 'Elevador',
                                            'Portaria 24h' => 'Portaria 24h',
                                            'Salão de festas' => 'Salão de festas',
                                            'Academia' => 'Academia',
                                            'Piscina' => 'Piscina',
                                            'Quadra poliesportiva' => 'Quadra poliesportiva',
                                            'Playground' => 'Playground',
                                            'Condomínio fechado' => 'Condomínio fechado',
                                            'Segurança 24h' => 'Segurança 24h',
                                            'Vestiários' => 'Vestiários',
                                            'Refeitório' => 'Refeitório',
                                            'Energia elétrica' => 'Energia elétrica',
                                            'Internet' => 'Internet',
                                            'Estrada asfaltada' => 'Estrada asfaltada',
                                            'Heliponto' => 'Heliponto',
                                            'Estacionamento' => 'Estacionamento',
                                            'Sistema de segurança' => 'Sistema de segurança',
                                        ];
                                    @endphp

                                    @foreach($availableAmenities as $value => $label)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="amenities[]" value="{{ $value }}"
                                                   {{ in_array($value, request('amenities', [])) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                            <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex space-x-2 pt-4">
                            <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition font-medium">
                                Filtrar
                            </button>
                            <a href="{{ route('properties.index.public') }}" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition text-gray-700">
                                Limpar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Properties List -->
            <div class="lg:w-3/4">
                <!-- Sort Controls -->
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">Ordenar por:</span>
                            <select onchange="changeSort(this.value)"
                                    class="px-3 py-1 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option class="" value="created_at_desc" {{ request('sort') === 'created_at' && request('direction') === 'desc' ? 'selected' : '' }}>
                                    Mais recentes
                                </option>
                                <option class="" value="price_asc" {{ request('sort') === 'price' && request('direction') === 'asc' ? 'selected' : '' }}>
                                    Menor preço
                                </option>
                                <option class="" value="price_desc" {{ request('sort') === 'price' && request('direction') === 'desc' ? 'selected' : '' }}>
                                    Maior preço
                                </option>
                                <option class="" value="area_desc" {{ request('sort') === 'area' && request('direction') === 'desc' ? 'selected' : '' }}>
                                    Maior área
                                </option>
                            </select>
                        </div>

                        <!-- View Toggle -->
                        <div class="flex items-center space-x-2 border-t border-gray-200 pt-4">
                            <span class="text-sm text-gray-600 mr-2">Visualização:</span>
                            <button @click="viewMode = 'grid'; updateViewMode('grid')"
                                    :class="viewMode === 'grid' ? 'bg-primary-100 text-primary-600' : 'text-gray-400 hover:text-gray-600'"
                                    class="p-2 rounded-md transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </button>
                            <button @click="viewMode = 'list'; updateViewMode('list')"
                                    :class="viewMode === 'list' ? 'bg-primary-100 text-primary-600' : 'text-gray-400 hover:text-gray-600'"
                                    class="p-2 rounded-md transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Properties Display -->
                @if($properties->count() > 0)
                    <!-- Grid View -->
                    <div x-show="viewMode === 'grid'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($properties as $property)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                                <!-- Property Image -->
                                <div class="relative h-48 bg-gray-200">
                                    @if($property->main_image_url)
                                        <img src="{{ $property->thumbnail_url }}" alt="{{ $property->title }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                    @endif

                                    <!-- Badges -->
                                    <div class="absolute top-3 left-3 flex flex-col space-y-1">
                                        @if($property->featured)
                                            <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded font-medium">
                                                Destaque
                                            </span>
                                        @endif
                                        @if($property->urgent)
                                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded font-medium">
                                                Urgente
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Price Badge -->
                                    <div class="absolute top-3 right-3">
                                        <span class="bg-black bg-opacity-75 text-white px-3 py-1 rounded-lg font-semibold">
                                            {{ $property->formatted_price }}
                                        </span>
                                    </div>

                                    <!-- Favorite Button -->
                                    @auth
                                        <button onclick="toggleFavorite({{ $property->id }})"
                                                class="absolute bottom-3 right-3 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-50 transition">
                                            <svg class="w-5 h-5 {{ $property->isFavoritedBy(auth()->user()) ? 'text-red-500 fill-current' : 'text-gray-400' }}"
                                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        </button>
                                    @endauth
                                </div>

                                <!-- Property Info -->
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-orange-600 font-medium">{{ $property->type_label }}</span>
                                        <span class="text-sm text-gray-500">{{ $property->category->name }}</span>
                                    </div>

                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        <a href="{{ route('properties.show', $property) }}" class="hover:text-orange-600">
                                            {{ $property->title }}
                                        </a>
                                    </h3>

                                    <p class="text-gray-600 text-sm mb-4">
                                        {{ $property->address }}, {{ $property->neighborhood }}
                                    </p>

                                    <!-- Property Features -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                                            @if($property->bedrooms)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                    </svg>
                                                    {{ $property->bedrooms }}
                                                </span>
                                            @endif

                                            @if($property->bathrooms)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                    </svg>
                                                    {{ $property->bathrooms }}
                                                </span>
                                            @endif

                                            @if($property->area)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                                    </svg>
                                                    {{ $property->area }}m²
                                                </span>
                                            @endif
                                        </div>

                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('properties.show', $property) }}"
                                               class="text-orange-600 hover:text-orange-800 text-sm font-medium">
                                                Ver anúncio
                                            </a>
                                            @auth
                                                @if(auth()->user()->isCorretor())
                                                    <a href="{{ route('properties.edit', $property) }}"
                                                       class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </a>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- List View -->
                    <div x-show="viewMode === 'list'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="space-y-4">
                        @foreach($properties as $property)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                                <div class="flex flex-col md:flex-row">
                                    <!-- Property Image -->
                                    <div class="md:w-1/3">
                                        <div class="relative h-48 md:h-full bg-gray-200">
                                            @if($property->main_image_url)
                                                <img src="{{ $property->thumbnail_url }}" alt="{{ $property->title }}"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                    </svg>
                                                </div>
                                            @endif

                                            <!-- Badges -->
                                            <div class="absolute top-3 left-3 flex flex-col space-y-1">
                                                @if($property->featured)
                                                    <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded font-medium">
                                                        Destaque
                                                    </span>
                                                @endif
                                                @if($property->urgent)
                                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded font-medium">
                                                        Urgente
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Price Badge -->
                                            <div class="absolute top-3 right-3">
                                                <span class="bg-black bg-opacity-80 text-white px-3 py-1 rounded-lg font-bold text-sm">
                                                    {{ $property->formatted_price }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Property Info -->
                                    <div class="md:w-2/3 p-6">
                                        <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-4">
                                            <div class="flex-1">
                                                <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                                    <a href="{{ route('properties.show', $property) }}" class="hover:text-blue-600">
                                                        {{ $property->title }}
                                                    </a>
                                                </h3>
                                                <p class="text-gray-600 mb-2">
                                                    📍 {{ $property->neighborhood }}, {{ $property->city }} - {{ $property->state }}
                                                </p>
                                            </div>
                                            <div class="mt-2 md:mt-0 md:ml-4">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                    {{ $property->type_label }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Features -->
                                        <div class="flex flex-wrap gap-4 mb-4 text-sm text-gray-600">
                                            @if($property->bedrooms)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                    </svg>
                                                    {{ $property->bedrooms }} quarto{{ $property->bedrooms > 1 ? 's' : '' }}
                                                </span>
                                            @endif

                                            @if($property->bathrooms)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                    </svg>
                                                    {{ $property->bathrooms }} banheiro{{ $property->bathrooms > 1 ? 's' : '' }}
                                                </span>
                                            @endif

                                            @if($property->area)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                                    </svg>
                                                    {{ $property->area }} m²
                                                </span>
                                            @endif

                                            @if($property->parking_spaces)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                    </svg>
                                                    {{ $property->parking_spaces }} vaga{{ $property->parking_spaces > 1 ? 's' : '' }}
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Description Preview -->
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                            {{ Str::limit(strip_tags($property->description), 150) }}
                                        </p>

                                        <!-- Actions -->
                                        <div class="flex flex-col sm:flex-row gap-3">
                                            <a href="{{ route('properties.show', $property) }}"
                                               class="flex-1 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition text-center font-medium">
                                                Ver Detalhes
                                            </a>

                                            @auth
                                                @if(auth()->user()->isCorretor())
                                                    <a href="{{ route('properties.edit', $property) }}"
                                                       class="px-4 py-2 bg-blue-100 text-blue-700 border border-blue-300 rounded-lg hover:bg-blue-200 transition text-center font-medium flex items-center justify-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </a>
                                                @else
                                                    <button onclick="toggleFavorite({{ $property->id }})"
                                                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center justify-center">
                                                        <svg class="w-5 h-5 {{ $property->isFavoritedBy(auth()->user()) ? 'text-red-500 fill-current' : 'text-gray-400' }}"
                                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                        </svg>
                                                    </button>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $properties->appends(request()->query())->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                        <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Nenhum anúncio encontrado</h3>
                        <p class="mt-2 text-gray-500">
                            Tente ajustar os filtros ou <a href="{{ route('properties.index.public') }}" class="text-orange-600 hover:text-orange-800">limpar todos os filtros</a>.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function changeSort(value) {
    const [sort, direction] = value.split('_');
    const url = new URL(window.location);

    if (sort === 'created_at' && direction === 'desc') {
        url.searchParams.delete('sort');
        url.searchParams.delete('direction');
    } else {
        url.searchParams.set('sort', sort);
        url.searchParams.set('direction', direction);
    }

    window.location.href = url.toString();
}

function updateViewMode(mode) {
    const url = new URL(window.location);
    if (mode === 'grid') {
        url.searchParams.delete('view');
    } else {
        url.searchParams.set('view', mode);
    }
    window.location.href = url.toString();
}

@auth
function toggleFavorite(propertyId) {
    fetch(`/properties/${propertyId}/favorite`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        // Reload the page to update the favorite status
        window.location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erro ao atualizar favorito');
    });
}
@endauth
</script>
@endsection
