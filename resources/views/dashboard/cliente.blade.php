@extends('layouts.app')

@section('title', 'Meu Painel - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Meu Painel</h1>
                    <p class="text-gray-600 mt-1">Bem-vindo de volta, {{ auth()->user()->name }}!</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Último acesso</p>
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->last_login_at?->format('d/m/Y H:i') ?? 'Primeiro acesso' }}</p>
                    </div>
                    <div class="w-12 h-12 bg-primary-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Estatísticas Rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Imóveis Favoritados -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Imóveis Favoritados</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['favorite_properties'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Contatos Enviados -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Contatos Enviados</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['sent_contacts'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Visitas Agendadas -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Visitas Confirmadas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['scheduled_visits'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Ações Rápidas</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('properties.index.public') }}" class="flex items-center justify-center px-4 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Buscar Imóveis
                </a>
                <a href="{{ route('properties.favorites') }}" class="flex items-center justify-center px-4 py-3 bg-secondary-600 text-white rounded-lg hover:bg-secondary-700 transition font-medium">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    Meus Favoritos
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center justify-center px-4 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Meu Perfil
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Imóveis Favoritados Recentes -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Favoritos Recentes</h2>
                    <a href="{{ route('properties.favorites') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                        Ver todos
                    </a>
                </div>

                @if($stats['recent_favorites']->count() > 0)
                    <div class="space-y-4">
                        @foreach($stats['recent_favorites'] as $favorite)
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded-lg overflow-hidden">
                                    @if($favorite->property->main_image)
                                        <img src="{{ $favorite->property->main_image_url }}" alt="{{ $favorite->property->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM3 5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $favorite->property->title }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        R$ {{ number_format($favorite->property->price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        {{ $favorite->property->city }} - {{ $favorite->property->state }}
                                    </p>
                                </div>
                                <a href="{{ route('properties.show', $favorite->property) }}" class="text-primary-600 hover:text-primary-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <p class="text-gray-500 text-sm">Você ainda não favoritou nenhum imóvel</p>
                        <a href="{{ route('properties.index.public') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium mt-2 inline-block">
                            Explorar imóveis →
                        </a>
                    </div>
                @endif
            </div>

            <!-- Contatos Recentes -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Contatos Recentes</h2>
                    <span class="text-sm text-gray-500">{{ $stats['sent_contacts'] }} total</span>
                </div>

                @if($stats['recent_contacts']->count() > 0)
                    <div class="space-y-4">
                        @foreach($stats['recent_contacts'] as $contact)
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $contact->property->title }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Enviado para {{ $contact->receiver->name }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        {{ $contact->created_at ? $contact->created_at->format('d/m/Y H:i') : 'N/A' }}
                                    </p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                        @if($contact->status === \App\Models\Contact::STATUS_SENT) bg-yellow-100 text-yellow-800
                                        @elseif($contact->status === \App\Models\Contact::STATUS_REPLIED) bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $contact->status_label }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-500 text-sm">Você ainda não entrou em contato com corretores</p>
                        <a href="{{ route('properties.index.public') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium mt-2 inline-block">
                            Buscar imóveis →
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Dicas e Ajuda -->
        <div class="bg-gradient-to-r from-primary-500 to-secondary-600 rounded-lg shadow-sm p-6 mt-8 text-white">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold mb-2">Dicas para encontrar o imóvel ideal</h3>
                    <ul class="space-y-1 text-sm opacity-90">
                        <li>• Use filtros específicos para refinar sua busca (preço, localização, características)</li>
                        <li>• Favorite imóveis que você gostar para comparar depois</li>
                        <li>• Entre em contato diretamente com corretores via WhatsApp</li>
                        <li>• Salve suas buscas favoritas para receber alertas de novos imóveis</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
