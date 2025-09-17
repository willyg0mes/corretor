@extends('layouts.app')

@section('title', 'Editar Imóvel - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Editar Imóvel</h1>
                    <p class="text-gray-600 mt-1">Atualize os dados do imóvel</p>
                </div>
                <a href="{{ route('properties.show', $property) }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Voltar
                </a>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

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
                        <input type="text" name="title" value="{{ old('title', $property->title) }}"
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
                                <option value="{{ $category->id }}" {{ old('category_id', $property->category_id) == $category->id ? 'selected' : '' }}>
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
                            <option value="venda" {{ old('type', $property->type) == 'venda' ? 'selected' : '' }}>Venda</option>
                            <option value="aluguel" {{ old('type', $property->type) == 'aluguel' ? 'selected' : '' }}>Aluguel</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Preço -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preço (R$) *</label>
                        <input type="number" name="price" value="{{ old('price', $property->price) }}" step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('price') border-red-500 @enderror"
                               placeholder="Ex: 500000.00">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Área -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Área (m²) *</label>
                        <input type="number" name="area" value="{{ old('area', $property->area) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('area') border-red-500 @enderror"
                               placeholder="Ex: 85">
                        @error('area')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quartos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quartos</label>
                        <input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('bedrooms') border-red-500 @enderror"
                               placeholder="Ex: 3">
                        @error('bedrooms')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Banheiros -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banheiros</label>
                        <input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('bathrooms') border-red-500 @enderror"
                               placeholder="Ex: 2">
                        @error('bathrooms')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vagas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Vagas de Garagem</label>
                        <input type="number" name="parking_spaces" value="{{ old('parking_spaces', $property->parking_spaces) }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('parking_spaces') border-red-500 @enderror"
                               placeholder="Ex: 1">
                        @error('parking_spaces')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Área do Terreno -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Área do Terreno (m²)</label>
                        <input type="number" name="land_area" value="{{ old('land_area', $property->land_area) }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('land_area') border-red-500 @enderror"
                               placeholder="Ex: 350">
                        @error('land_area')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Localização -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Localização
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Endereço -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Endereço *</label>
                        <input type="text" name="address" value="{{ old('address', $property->address) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('address') border-red-500 @enderror"
                               placeholder="Ex: Rua das Flores, 123">
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bairro -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bairro *</label>
                        <input type="text" name="neighborhood" value="{{ old('neighborhood', $property->neighborhood) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('neighborhood') border-red-500 @enderror"
                               placeholder="Ex: Centro">
                        @error('neighborhood')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cidade -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cidade *</label>
                        <input type="text" name="city" value="{{ old('city', $property->city ?: 'Alexânia') }}"
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
                            <option value="GO" {{ old('state', $property->state ?: 'GO') == 'GO' ? 'selected' : '' }}>Goiás</option>
                            <option value="AC" {{ old('state', $property->state) == 'AC' ? 'selected' : '' }}>Acre</option>
                            <option value="AL" {{ old('state', $property->state) == 'AL' ? 'selected' : '' }}>Alagoas</option>
                            <option value="AP" {{ old('state', $property->state) == 'AP' ? 'selected' : '' }}>Amapá</option>
                            <option value="AM" {{ old('state', $property->state) == 'AM' ? 'selected' : '' }}>Amazonas</option>
                            <option value="BA" {{ old('state', $property->state) == 'BA' ? 'selected' : '' }}>Bahia</option>
                            <option value="CE" {{ old('state', $property->state) == 'CE' ? 'selected' : '' }}>Ceará</option>
                            <option value="DF" {{ old('state', $property->state) == 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                            <option value="ES" {{ old('state', $property->state) == 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                            <option value="GO" {{ old('state', $property->state) == 'GO' ? 'selected' : '' }}>Goiás</option>
                            <option value="MA" {{ old('state', $property->state) == 'MA' ? 'selected' : '' }}>Maranhão</option>
                            <option value="MT" {{ old('state', $property->state) == 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                            <option value="MS" {{ old('state', $property->state) == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                            <option value="MG" {{ old('state', $property->state) == 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                            <option value="PA" {{ old('state', $property->state) == 'PA' ? 'selected' : '' }}>Pará</option>
                            <option value="PB" {{ old('state', $property->state) == 'PB' ? 'selected' : '' }}>Paraíba</option>
                            <option value="PR" {{ old('state', $property->state) == 'PR' ? 'selected' : '' }}>Paraná</option>
                            <option value="PE" {{ old('state', $property->state) == 'PE' ? 'selected' : '' }}>Pernambuco</option>
                            <option value="PI" {{ old('state', $property->state) == 'PI' ? 'selected' : '' }}>Piauí</option>
                            <option value="RJ" {{ old('state', $property->state) == 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                            <option value="RN" {{ old('state', $property->state) == 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                            <option value="RS" {{ old('state', $property->state) == 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                            <option value="RO" {{ old('state', $property->state) == 'RO' ? 'selected' : '' }}>Rondônia</option>
                            <option value="RR" {{ old('state', $property->state) == 'RR' ? 'selected' : '' }}>Roraima</option>
                            <option value="SC" {{ old('state', $property->state) == 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                            <option value="SP" {{ old('state', $property->state) == 'SP' ? 'selected' : '' }}>São Paulo</option>
                            <option value="SE" {{ old('state', $property->state) == 'SE' ? 'selected' : '' }}>Sergipe</option>
                            <option value="TO" {{ old('state', $property->state) == 'TO' ? 'selected' : '' }}>Tocantins</option>
                        </select>
                        @error('state')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CEP -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">CEP</label>
                        <input type="text" name="zip_code" value="{{ old('zip_code', $property->zip_code) }}"
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
                              placeholder="Descreva detalhadamente o imóvel, suas características, localização, etc.">{{ old('description', $property->description) }}</textarea>
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
                                           {{ in_array($feature, old('features', $property->features ?? [])) ? 'checked' : '' }}
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
                            @foreach(['Piscina', 'Academia', 'Salão de festas', 'Churrasqueira', 'Quadra poliesportiva', 'Playground', 'Portaria 24h', 'Elevador', 'Garagem coletiva', 'Área verde', 'Sauna', 'Espaço gourmet'] as $amenity)
                                <label class="flex items-center">
                                    <input type="checkbox" name="amenities[]" value="{{ $amenity }}"
                                           {{ in_array($amenity, old('amenities', $property->amenities ?? [])) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $amenity }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
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
                               {{ old('featured', $property->featured) ? 'checked' : '' }}
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
                               {{ old('urgent', $property->urgent) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <label for="urgent" class="ml-3 flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            Marcar como Urgente
                            <span class="ml-2 text-xs text-gray-500 bg-red-100 px-2 py-1 rounded">Badge vermelho "Urgente"</span>
                        </label>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status do Anúncio *</label>
                        <select name="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('status') border-red-500 @enderror">
                            <option value="ativo" {{ old('status', $property->status) == 'ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="inativo" {{ old('status', $property->status) == 'inativo' ? 'selected' : '' }}>Inativo</option>
                            <option value="vendido" {{ old('status', $property->status) == 'vendido' ? 'selected' : '' }}>Vendido</option>
                            <option value="alugado" {{ old('status', $property->status) == 'alugado' ? 'selected' : '' }}>Alugado</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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

            <!-- Ações -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('properties.show', $property) }}"
                   class="px-6 py-3 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-3 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition">
                    Atualizar Imóvel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
