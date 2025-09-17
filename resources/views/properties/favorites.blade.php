@extends('layouts.app')

@section('title', 'Meus Favoritos - Corretor Imóveis')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Meus Favoritos</h1>
                        <p class="text-gray-600 mt-1">{{ $favorites->total() }} imóveis favoritados</p>
                    </div>
                </div>

                <a href="{{ route('properties.index.public') }}"
                   class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Buscar imóveis</span>
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($favorites->count() > 0)
            <!-- Properties Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($favorites as $favorite)
                    @php
                        $property = $favorite->property;
                    @endphp
                    <div class="property-card card-hover animate-fade-in">
                        <!-- Property Image -->
                        <div class="property-card-image">
                            @if($property->main_image_url)
                                <img src="{{ $property->thumbnail_url }}" alt="{{ $property->title }}"
                                     class="card-image">
                            @else
                                <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            @endif

                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex flex-col space-y-2">
                                @if($property->featured)
                                    <span class="property-card-badge property-card-badge-primary">
                                        ⭐ Destaque
                                    </span>
                                @endif
                                @if($property->urgent)
                                    <span class="property-card-badge bg-red-100 text-red-800">
                                        ⚡ Urgente
                                    </span>
                                @endif
                                <span class="property-card-badge bg-red-100 text-red-800">
                                    ❤️ Favoritado
                                </span>
                            </div>

                            <!-- Price Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="bg-black bg-opacity-80 text-white px-4 py-2 rounded-xl font-bold text-lg shadow-lg backdrop-blur-sm">
                                    {{ $property->formatted_price }}
                                </span>
                            </div>

                            <!-- Remove from Favorites Button -->
                            <button onclick="toggleFavorite({{ $property->id }})"
                                    class="absolute top-3 right-3 ml-12 w-10 h-10 bg-red-500/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-red-600 transition-all duration-200">
                                <svg class="w-5 h-5 text-white" fill="currentColor" stroke="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Property Info -->
                        <div class="property-card-content">
                            <div class="flex items-center justify-between mb-3">
                                <span class="property-card-price">{{ $property->formatted_price }}</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-secondary-100 text-secondary-800">
                                    {{ $property->type_label }}
                                </span>
                            </div>

                            <h3 class="property-card-title">
                                <a href="{{ route('properties.show', $property) }}">
                                    {{ $property->title }}
                                </a>
                            </h3>

                            <p class="property-card-location">
                                📍 {{ $property->neighborhood }}, {{ $property->city }}
                            </p>

                            <!-- Property Features -->
                            <div class="property-card-features">
                                @if($property->bedrooms)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                        {{ $property->bedrooms }}
                                    </span>
                                @endif

                                @if($property->bathrooms)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                        {{ $property->bathrooms }}
                                    </span>
                                @endif

                                @if($property->area)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                        </svg>
                                        {{ $property->area }}m²
                                    </span>
                                @endif
                            </div>

                            <!-- Action Button -->
                            <div class="mt-6">
                                <a href="{{ route('properties.show', $property) }}"
                                   class="btn-primary w-full justify-center">
                                    Ver anúncio completo
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $favorites->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Nenhum favorito ainda</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">
                    Você ainda não favoritou nenhum imóvel. Explore nossos anúncios e salve os que mais gostar!
                </p>
                <a href="{{ route('properties.index.public') }}"
                   class="btn-primary inline-flex items-center px-6 py-3">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Explorar imóveis
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function toggleFavorite(propertyId) {
    if (!confirm('Tem certeza que deseja remover este imóvel dos favoritos?')) {
        return;
    }

    fetch(`/properties/${propertyId}/favorite`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            _method: 'POST'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload the page to update the favorites list
            window.location.reload();
        } else {
            alert('Erro ao remover dos favoritos. Tente novamente.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erro ao remover dos favoritos. Tente novamente.');
    });
}
</script>
@endsection
