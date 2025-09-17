@extends('layouts.app')

@section('title', 'Cadastrar Novo Imóvel - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Cadastrar Novo Imóvel</h1>
                    <p class="text-gray-600 mt-1">Preencha os dados do imóvel para cadastrar no sistema</p>
                </div>
                <a href="{{ route('properties.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Voltar
                </a>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Informações Básicas -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Informações Básicas
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Título -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Título do Anúncio *</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('title') border-red-500 @enderror"
                               placeholder="Ex: Apartamento 3 quartos - Jardins">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categoria -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Categoria *</label>
                        <select name="category_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('category_id') border-red-500 @enderror">
                            <option value="">Selecione uma categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo *</label>
                        <select name="type"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('type') border-red-500 @enderror">
                            <option value="venda" {{ old('type', 'venda') == 'venda' ? 'selected' : '' }}>Venda</option>
                            <option value="aluguel" {{ old('type') == 'aluguel' ? 'selected' : '' }}>Aluguel</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Preço -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preço (R$) *</label>
                        <input type="number" name="price" value="{{ old('price') }}" step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('price') border-red-500 @enderror"
                               placeholder="Ex: 500000.00">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Área -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Área (m²) *</label>
                        <input type="number" name="area" value="{{ old('area') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('area') border-red-500 @enderror"
                               placeholder="Ex: 85">
                        @error('area')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Características -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Características
                </h2>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Quartos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quartos</label>
                        <input type="number" name="bedrooms" value="{{ old('bedrooms') }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('bedrooms') border-red-500 @enderror">
                        @error('bedrooms')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Banheiros -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banheiros</label>
                        <input type="number" name="bathrooms" value="{{ old('bathrooms') }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('bathrooms') border-red-500 @enderror">
                        @error('bathrooms')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vagas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Vagas</label>
                        <input type="number" name="parking_spaces" value="{{ old('parking_spaces') }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('parking_spaces') border-red-500 @enderror">
                        @error('parking_spaces')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Área do Terreno -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Área do Terreno (m²)</label>
                        <input type="number" name="land_area" value="{{ old('land_area') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('land_area') border-red-500 @enderror">
                        @error('land_area')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Localização -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Localização
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Endereço -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Endereço *</label>
                        <input type="text" name="address" value="{{ old('address') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('address') border-red-500 @enderror"
                               placeholder="Ex: Rua das Flores, 123">
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bairro -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bairro *</label>
                        <input type="text" name="neighborhood" value="{{ old('neighborhood') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('neighborhood') border-red-500 @enderror"
                               placeholder="Ex: Centro">
                        @error('neighborhood')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cidade -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cidade *</label>
                        <input type="text" name="city" value="{{ old('city', 'Alexânia') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('city') border-red-500 @enderror"
                               placeholder="Ex: Alexânia">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                        <select name="state"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('state') border-red-500 @enderror">
                            <option value="GO" {{ old('state', 'GO') == 'GO' ? 'selected' : '' }}>Goiás</option>
                            <option value="AC" {{ old('state') == 'AC' ? 'selected' : '' }}>Acre</option>
                            <option value="AL" {{ old('state') == 'AL' ? 'selected' : '' }}>Alagoas</option>
                            <option value="AP" {{ old('state') == 'AP' ? 'selected' : '' }}>Amapá</option>
                            <option value="AM" {{ old('state') == 'AM' ? 'selected' : '' }}>Amazonas</option>
                            <option value="BA" {{ old('state') == 'BA' ? 'selected' : '' }}>Bahia</option>
                            <option value="CE" {{ old('state') == 'CE' ? 'selected' : '' }}>Ceará</option>
                            <option value="DF" {{ old('state') == 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                            <option value="ES" {{ old('state') == 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                            <option value="GO" {{ old('state') == 'GO' ? 'selected' : '' }}>Goiás</option>
                            <option value="MA" {{ old('state') == 'MA' ? 'selected' : '' }}>Maranhão</option>
                            <option value="MT" {{ old('state') == 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                            <option value="MS" {{ old('state') == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                            <option value="MG" {{ old('state') == 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                            <option value="PA" {{ old('state') == 'PA' ? 'selected' : '' }}>Pará</option>
                            <option value="PB" {{ old('state') == 'PB' ? 'selected' : '' }}>Paraíba</option>
                            <option value="PR" {{ old('state') == 'PR' ? 'selected' : '' }}>Paraná</option>
                            <option value="PE" {{ old('state') == 'PE' ? 'selected' : '' }}>Pernambuco</option>
                            <option value="PI" {{ old('state') == 'PI' ? 'selected' : '' }}>Piauí</option>
                            <option value="RJ" {{ old('state') == 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                            <option value="RN" {{ old('state') == 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                            <option value="RS" {{ old('state') == 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                            <option value="RO" {{ old('state') == 'RO' ? 'selected' : '' }}>Rondônia</option>
                            <option value="RR" {{ old('state') == 'RR' ? 'selected' : '' }}>Roraima</option>
                            <option value="SC" {{ old('state') == 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                            <option value="SP" {{ old('state') == 'SP' ? 'selected' : '' }}>São Paulo</option>
                            <option value="SE" {{ old('state') == 'SE' ? 'selected' : '' }}>Sergipe</option>
                            <option value="TO" {{ old('state') == 'TO' ? 'selected' : '' }}>Tocantins</option>
                        </select>
                        @error('state')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CEP -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">CEP</label>
                        <input type="text" name="zip_code" value="{{ old('zip_code') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('zip_code') border-red-500 @enderror"
                               placeholder="Ex: 01234-567">
                        @error('zip_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Descrição -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Descrição
                </h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descrição Completa *</label>
                    <textarea name="description" rows="6"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('description') border-red-500 @enderror"
                              placeholder="Descreva detalhadamente o imóvel, suas características, localização, etc.">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Características e Comodidades -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Características e Comodidades
                </h2>

                <div class="space-y-6">
                    <!-- Características Internas -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Características Internas</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach(['Ar condicionado', 'Mobiliado', 'Vista para rua', 'Suíte master', 'Cozinha planejada', 'Lavanderia', 'Escritório', 'Sala de jantar', 'Área de serviço', 'Despensa', 'Sacada', 'Varanda gourmet'] as $feature)
                                <label class="flex items-center">
                                    <input type="checkbox" name="features[]" value="{{ $feature }}"
                                           {{ in_array($feature, old('features', [])) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $feature }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Comodidades do Condomínio -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Comodidades do Condomínio</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach(['Piscina', 'Academia', 'Salão de festas', 'Churrasqueira', 'Quadra de esportes', 'Playground', 'Portaria 24h', 'Elevador', 'Estacionamento visitantes', 'Jardim', 'Sauna', 'Espaço gourmet'] as $amenity)
                                <label class="flex items-center">
                                    <input type="checkbox" name="amenities[]" value="{{ $amenity }}"
                                           {{ in_array($amenity, old('amenities', [])) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $amenity }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Imagens -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Imagens do Imóvel
                </h2>

                <div class="space-y-4">
                    <!-- Aviso sobre uploads grandes -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-blue-800">Upload de Arquivos Grandes</h4>
                                <p class="text-sm text-blue-700 mt-1">
                                    O sistema suporta arquivos grandes. Se o upload demorar, aguarde o processamento completo.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fotos do Imóvel *</label>
                        <input type="file" name="images[]" multiple accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('images') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">Selecione múltiplas imagens (máximo 10 imagens, cada uma até 25MB)</p>
                        @error('images')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="image-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                </div>
            </div>

            <!-- Configurações do Anúncio -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    Configurações do Anúncio
                </h2>

                <div class="space-y-4">
                    <!-- Destaque -->
                    <div class="flex items-center">
                        <input type="checkbox" name="featured" value="1" id="featured"
                               {{ old('featured') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <label for="featured" class="ml-3 flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            Marcar como Destaque
                            <span class="ml-2 text-xs text-gray-500 bg-yellow-100 px-2 py-1 rounded">Anúncio destacado na listagem</span>
                        </label>
                    </div>

                    <!-- Urgente -->
                    <div class="flex items-center">
                        <input type="checkbox" name="urgent" value="1" id="urgent"
                               {{ old('urgent') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <label for="urgent" class="ml-3 flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            Marcar como Urgente
                            <span class="ml-2 text-xs text-gray-500 bg-red-100 px-2 py-1 rounded">Badge vermelho "Urgente"</span>
                        </label>
                    </div>

                    <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                        <div class="flex">
                            <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-blue-800">Sobre destaques e anúncios urgentes</h4>
                                <p class="mt-1 text-sm text-blue-700">
                                    Anúncios marcados como <strong>destaque</strong> aparecem no topo das listagens e têm maior visibilidade.
                                    Anúncios <strong>urgentes</strong> exibem um badge vermelho para chamar mais atenção dos compradores.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vídeos (Opcional) -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Vídeos (Opcional)
                </h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Vídeos do Imóvel</label>
                        <input type="file" name="videos[]" multiple accept="video/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('videos') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">Selecione vídeos (máximo 3 vídeos, cada um até 300MB)</p>
                        @error('videos')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="video-preview" class="space-y-2"></div>
                </div>
            </div>

                <!-- Debug Info (remover depois) -->
            @if(config('app.debug'))
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <h4 class="text-sm font-medium text-yellow-800 mb-2">Debug Info</h4>
                <div class="text-xs text-yellow-700 space-y-1">
                    <div>CSRF Token: <code class="bg-yellow-100 px-1 rounded">{{ csrf_token() }}</code></div>
                    <div>User ID: <code class="bg-yellow-100 px-1 rounded">{{ auth()->id() }}</code></div>
                    <div>User Role: <code class="bg-yellow-100 px-1 rounded">{{ auth()->user()->role ?? 'unknown' }}</code></div>
                    <div>Route: <code class="bg-yellow-100 px-1 rounded">{{ route('properties.store') }}</code></div>
                </div>
            </div>
            @endif

            <!-- Ações -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('properties.index') }}"
                   class="px-6 py-3 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-3 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition">
                    Cadastrar Imóvel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Validação de tamanho dos arquivos antes do upload
function validateFileSizes() {
    const imageInput = document.querySelector('input[name="images[]"]');
    const videoInput = document.querySelector('input[name="videos[]"]');

    let totalSize = 0;
    let hasErrors = false;

    // Validar imagens
    if (imageInput.files.length > 0) {
        if (imageInput.files.length > 10) {
            alert('Máximo de 10 imagens permitido.');
            hasErrors = true;
        }

        Array.from(imageInput.files).forEach(file => {
            totalSize += file.size;
            if (file.size > 25 * 1024 * 1024) { // 25MB
                alert(`Imagem "${file.name}" é muito grande. Máximo 25MB por imagem.`);
                hasErrors = true;
            }
        });
    }

    // Validar vídeos
    if (videoInput.files.length > 0) {
        if (videoInput.files.length > 3) {
            alert('Máximo de 3 vídeos permitido.');
            hasErrors = true;
        }

        Array.from(videoInput.files).forEach(file => {
            totalSize += file.size;
            if (file.size > 300 * 1024 * 1024) { // 300MB
                alert(`Vídeo "${file.name}" é muito grande. Máximo 300MB por vídeo.`);
                hasErrors = true;
            }
        });
    }

    // Verificar tamanho total
    const totalMB = totalSize / (1024 * 1024);
    if (totalMB > 500) { // 500MB total
        alert(`Tamanho total dos arquivos (${totalMB.toFixed(1)}MB) é muito grande. Considere fazer upload em lotes menores.`);
        hasErrors = true;
    }

    return !hasErrors;
}

// Preview de imagens
document.querySelector('input[name="images[]"]').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';

    // Validar arquivos
    if (!validateFileSizes()) {
        e.target.value = ''; // Limpar seleção
        return;
    }

    Array.from(e.target.files).forEach((file, index) => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg">
                    <button type="button" onclick="removeImage(${index})"
                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                        ×
                    </button>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        }
    });
});

// Preview de vídeos
document.querySelector('input[name="videos[]"]').addEventListener('change', function(e) {
    const preview = document.getElementById('video-preview');
    preview.innerHTML = '';

    // Validar arquivos
    if (!validateFileSizes()) {
        e.target.value = ''; // Limpar seleção
        return;
    }

    Array.from(e.target.files).forEach((file, index) => {
        if (file.type.startsWith('video/')) {
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-3 p-3 bg-gray-50 rounded-lg';
            div.innerHTML = `
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">${file.name}</p>
                    <p class="text-xs text-gray-500">${(file.size / 1024 / 1024).toFixed(1)} MB</p>
                </div>
                <button type="button" onclick="removeVideo(${index})"
                        class="text-red-500 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            preview.appendChild(div);
        }
    });
});

// Interceptar submissão do formulário para validação final
document.querySelector('form').addEventListener('submit', function(e) {
    console.log('🔄 Formulário sendo submetido');

    // Validar arquivos antes do envio
    if (!validateFileSizes()) {
        console.log('❌ Validação de arquivos falhou');
        e.preventDefault();
        return false;
    }

    console.log('✅ Validação de arquivos passou');

    // Coletar dados do formulário para debug
    const formData = new FormData(this);
    const formDataObj = {};
    for (let [key, value] of formData.entries()) {
        if (value instanceof File) {
            formDataObj[key] = `${value.name} (${(value.size / 1024 / 1024).toFixed(2)}MB)`;
        } else {
            formDataObj[key] = value;
        }
    }

    console.log('📋 Dados do formulário:', formDataObj);

    // Mostrar indicador de carregamento
    const submitBtn = document.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Enviando...';
    submitBtn.disabled = true;

    console.log('🚀 Enviando formulário para o servidor...');

    // Reabilitar botão após 30 segundos (fallback)
    setTimeout(() => {
        console.log('⏰ Timeout: reabilitando botão');
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    }, 30000);
});

function removeImage(index) {
    const input = document.querySelector('input[name="images[]"]');
    // Recriar FileList sem o arquivo removido (simplificado)
    const dt = new DataTransfer();
    const files = Array.from(input.files);
    files.splice(index, 1);
    files.forEach(file => dt.items.add(file));
    input.files = dt.files;

    // Recarregar preview
    input.dispatchEvent(new Event('change'));
}

function removeVideo(index) {
    const input = document.querySelector('input[name="videos[]"]');
    const dt = new DataTransfer();
    const files = Array.from(input.files);
    files.splice(index, 1);
    files.forEach(file => dt.items.add(file));
    input.files = dt.files;

    // Recarregar preview
    input.dispatchEvent(new Event('change'));
}
</script>
@endsection
