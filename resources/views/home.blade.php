@extends('layouts.app')

@section('title', 'Alaor - Corretor Imóveis - Compre, Venda e Alugue')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background with animated gradient -->
    <div class="absolute inset-0 hero-gradient animate-fade-in"></div>

    <!-- Animated background pattern -->
    <div class="absolute inset-0 hero-pattern opacity-5"></div>

    <!-- Floating geometric shapes -->
    <div class="absolute top-20 left-10 w-32 h-32 bg-white/5 rounded-full animate-bounce-subtle blur-xl"></div>
    <div class="absolute bottom-20 right-10 w-24 h-24 bg-secondary-300/10 rounded-full animate-bounce-subtle blur-lg" style="animation-delay: 1s;"></div>
    <div class="absolute top-1/2 right-20 w-20 h-20 bg-accent-300/10 rounded-full animate-bounce-subtle blur-lg" style="animation-delay: 2s;"></div>
    <div class="absolute top-40 right-1/4 w-16 h-16 bg-primary-300/10 rounded-full animate-bounce-subtle blur-md" style="animation-delay: 0.5s;"></div>

    <!-- Main content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="animate-slide-up">
            <!-- Logo/Brand -->
            <div class="mb-8 animate-fade-in" style="animation-delay: 0.2s;">
                <div class="inline-flex items-center space-x-4 bg-white/10 backdrop-blur-sm rounded-2xl px-6 py-4 border border-white/20">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-400 to-secondary-500 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="text-left">
                        <div class="text-2xl font-bold text-white">Corretor</div>
                        <div class="text-sm text-secondary-200 font-medium">Imóveis</div>
                    </div>
                </div>
            </div>

            <!-- Main headline -->
            <h1 class="text-6xl md:text-8xl font-black mb-8 leading-none animate-fade-in" style="animation-delay: 0.4s;">
                <span class="block text-white mb-2">O imóvel</span>
                <span class="block bg-gradient-to-r from-secondary-200 via-accent-200 to-primary-200 bg-clip-text text-transparent animate-shimmer">
                    perfeito
                </span>
                <span class="block text-white text-4xl md:text-6xl font-light mt-4">
                    está te esperando
                </span>
            </h1>

            <!-- Subtitle -->
            <p class="text-xl md:text-2xl text-white/90 mb-12 max-w-4xl mx-auto leading-relaxed animate-fade-in" style="animation-delay: 0.6s;">
                Conectamos compradores e vendedores com os melhores imóveis.
                <span class="font-semibold text-secondary-200">Sua jornada imobiliária começa aqui.</span>
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-16 animate-fade-in" style="animation-delay: 0.8s;">
                <a href="#destaques" class="btn-primary bg-white text-primary-600 hover:bg-neutral-600 px-10 py-5 text-xl font-bold shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-300 group" onclick="document.getElementById('destaques').scrollIntoView({behavior: 'smooth'})">
                    <svg class="w-6 h-6 inline mr-3 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                    Ver imóveis em destaque
                </a>

                @auth
                    @if(auth()->user()->isCorretor())
                        <a href="{{ route('properties.create') }}" class="border-2 border-white text-white hover:bg-white hover:text-primary-600 px-10 py-5 rounded-2xl text-xl font-bold transition-all duration-300 transform hover:-translate-y-1">
                            Anunciar imóvel
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="border-2 border-white text-white hover:bg-white hover:text-primary-600 px-10 py-5 rounded-2xl text-xl font-bold transition-all duration-300 transform hover:-translate-y-1">
                        Começar agora
                    </a>
                @endauth
            </div>

            <!-- Trust indicators -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-8 text-white/80 animate-fade-in" style="animation-delay: 1s;">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-secondary-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">Corretor verificado</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-accent-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">Imóveis certificados</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-primary-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">Atendimento 24/7</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce-subtle">
        <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
            <div class="w-1 h-3 bg-white/50 rounded-full mt-2 animate-bounce-subtle"></div>
        </div>
    </div>
</section>

<!-- Featured Properties -->
<section id="destaques" class="py-24 bg-gradient-to-br from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-fade-in">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Imóveis <span class="bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">em destaque</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                Selecionamos os melhores imóveis verificados pelos nossos corretores especializados
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('properties.index.public') }}"
                   class="btn-primary inline-flex items-center px-8 py-4 text-lg font-semibold shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Ver todos os imóveis
                </a>
                <a href="{{ route('properties.index.public', ['featured' => 1]) }}"
                   class="btn-secondary inline-flex items-center px-8 py-4 text-lg font-semibold">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    Apenas destaques
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse(\App\Models\Property::featured()->active()->published()->with(['category', 'images'])->limit(3)->get() as $property)
                <div class="property-card card-hover animate-fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
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
                        </div>

                        <!-- Price Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="bg-black bg-opacity-80 text-white px-4 py-2 rounded-xl font-bold text-lg shadow-lg backdrop-blur-sm">
                                {{ $property->formatted_price }}
                            </span>
                        </div>

                        <!-- Favorite Button -->
                        @auth
                            <button onclick="toggleFavorite({{ $property->id }})"
                                    class="absolute top-3 right-3 ml-12 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-all duration-200">
                                <svg class="w-5 h-5 {{ $property->isFavoritedBy(auth()->user()) ? 'text-red-500 fill-current' : 'text-gray-600' }} transition-colors"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        @endauth
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
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum anúncio em destaque</h3>
                    <p class="mt-1 text-sm text-gray-500">Novos anúncios serão adicionados em breve.</p>
                </div>
            @endforelse
        </div>

        <!-- Load More CTA -->
        <div class="text-center mt-16 animate-fade-in" style="animation-delay: 0.8s;">
            <p class="text-gray-600 mb-6 text-lg">Não encontrou o que procura?</p>
            <a href="{{ route('properties.index.public') }}"
               class="btn-primary inline-flex items-center px-10 py-4 text-lg font-semibold shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                Explorar todos os imóveis disponíveis
            </a>
        </div>
    </div>
</section>

<!-- Quick Search Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-primary-50/30">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="animate-slide-up">
            <h2 class="text-4xl font-bold text-gray-900 mb-6">
                Pronto para
                <span class="bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">encontrar seu imóvel</span>?
            </h2>
            <p class="text-xl text-gray-600 mb-12">
                Use nossa busca inteligente para encontrar exatamente o que você procura
            </p>

            <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-200 animate-fade-in" style="animation-delay: 0.3s;">
                <form id="search-form" action="{{ route('properties.index.public') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="form-label text-gray-700">Tipo</label>
                        <select name="type" class="form-select">
                            <option value="">Todos os tipos</option>
                            <option value="venda">Comprar</option>
                            <option value="aluguel">Alugar</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="form-label text-gray-700">Localização</label>
                        <input type="text" name="city" placeholder="Ex: Alexânia, GO"
                               class="form-input">
                    </div>

                    <div class="space-y-2">
                        <label class="form-label text-gray-700">Preço máximo</label>
                        <input type="number" name="max_price" placeholder="Ex: R$ 500.000"
                               class="form-input">
                    </div>
                </form>

                <div class="mt-8">
                    <button type="submit" form="search-form" class="btn-primary w-full py-4 text-lg font-semibold shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                        <svg class="w-6 h-6 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Buscar imóveis agora
                    </button>
                </div>

                <!-- Popular Searches -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600 mb-4">Buscas populares:</p>
                    <div class="flex flex-wrap justify-center gap-3">
                        <a href="{{ route('properties.index.public', ['city' => 'São Paulo']) }}" class="px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm hover:bg-primary-200 transition-all duration-200 transform hover:scale-105">São Paulo</a>
                        <a href="{{ route('properties.index.public', ['type' => 'venda']) }}" class="px-4 py-2 bg-secondary-100 text-secondary-700 rounded-full text-sm hover:bg-secondary-200 transition-all duration-200 transform hover:scale-105">À venda</a>
                        <a href="{{ route('properties.index.public', ['type' => 'aluguel']) }}" class="px-4 py-2 bg-accent-100 text-accent-700 rounded-full text-sm hover:bg-accent-200 transition-all duration-200 transform hover:scale-105">Aluguel</a>
                        <a href="{{ route('properties.index.public', ['max_price' => '300000']) }}" class="px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm hover:bg-primary-200 transition-all duration-200 transform hover:scale-105">Até R$ 300k</a>
                        <a href="{{ route('properties.index.public', ['features' => ['Piscina privativa']]) }}" class="px-4 py-2 bg-secondary-100 text-secondary-700 rounded-full text-sm hover:bg-secondary-200 transition-all duration-200 transform hover:scale-105">🏊‍♂️ Com piscina</a>
                        <a href="{{ route('properties.index.public', ['amenities' => ['Academia']]) }}" class="px-4 py-2 bg-accent-100 text-accent-700 rounded-full text-sm hover:bg-accent-200 transition-all duration-200 transform hover:scale-105">💪 Com academia</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-primary-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-fade-in">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                O que você
                <span class="bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">procura?</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Explore nossa variedade completa de imóveis e encontre exatamente o que precisa
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
            @foreach(\App\Models\Category::active()->ordered()->limit(10)->get() as $category)
                <a href="{{ route('properties.index.public', ['category_id' => $category->id]) }}"
                   class="group bg-white p-6 rounded-2xl border border-gray-200 hover:border-primary-300 shadow-soft hover:shadow-medium transition-all duration-300 hover:-translate-y-1 text-center">
                    <div class="text-4xl mb-4 transform group-hover:scale-110 transition-transform duration-300">{{ $category->icon_url }}</div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors text-base mb-2">{{ $category->name }}</h3>
                    <div class="flex items-center justify-center space-x-1">
                        <span class="text-sm font-medium text-primary-600">{{ $category->active_properties_count }}</span>
                        <span class="text-sm text-gray-500">anúncios</span>
                    </div>
                    <div class="mt-3 w-full bg-gray-200 rounded-full h-1 group-hover:bg-primary-200 transition-colors">
                        <div class="bg-primary-500 h-1 rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- View All Categories -->
        <div class="text-center mt-12">
            <a href="{{ route('properties.index.public') }}" class="btn-secondary inline-flex items-center space-x-2">
                <span>Ver todos os imóveis</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 animate-fade-in">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Por que escolher o
                <span class="bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">Alaor Corretor</span>?
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Descubra as vantagens que fazem da nossa plataforma a escolha ideal para sua jornada imobiliária
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="text-center group animate-slide-up" style="animation-delay: 0.2s;">
                <div class="bg-gradient-to-br from-primary-50 to-primary-100 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                    <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Imóveis Verificados</h3>
                <p class="text-gray-600 leading-relaxed">
                    Todos os anúncios passam por rigorosa verificação para garantir segurança e confiabilidade em cada negociação.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="text-center group animate-slide-up" style="animation-delay: 0.4s;">
                <div class="bg-gradient-to-br from-secondary-50 to-secondary-100 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                    <svg class="w-10 h-10 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Corretor Especializado</h3>
                <p class="text-gray-600 leading-relaxed">
                    Profissional qualificado e certificado CRECI pronto para acompanhar você em todo o processo de compra ou venda.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="text-center group animate-slide-up" style="animation-delay: 0.6s;">
                <div class="bg-gradient-to-br from-accent-50 to-accent-100 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                    <svg class="w-10 h-10 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Processo Rápido</h3>
                <p class="text-gray-600 leading-relaxed">
                    Tecnologia avançada que acelera todo o processo, desde a busca até a finalização do negócio imobiliário.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA Section -->
<section class="py-24 gradient-primary relative overflow-hidden">
    <div class="absolute inset-0 bg-black/5"></div>
    <div class="absolute top-10 left-10 w-32 h-32 bg-white/10 rounded-full animate-bounce-subtle blur-xl"></div>
    <div class="absolute bottom-10 right-10 w-24 h-24 bg-white/10 rounded-full animate-bounce-subtle blur-lg" style="animation-delay: 1s;"></div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="animate-slide-up">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Sua jornada
                <span class="block text-secondary-200">imobiliária começa aqui</span>
            </h2>
            <p class="text-xl text-primary-100 mb-10 max-w-2xl mx-auto leading-relaxed">
                Junte-se a milhares de pessoas que já encontraram seu lar dos sonhos através da nossa plataforma.
            </p>

            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                @auth
                    @if(auth()->user()->isCorretor())
                        <a href="{{ route('properties.create') }}"
                           class="btn-primary bg-white text-primary-600 hover:bg-neutral-50 px-8 py-4 text-lg font-semibold shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-6 h-6 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Começar a anunciar
                        </a>
                    @else
                        <a href="{{ route('properties.index.public') }}"
                           class="btn-primary bg-white text-primary-600 hover:bg-neutral-50 px-8 py-4 text-lg font-semibold shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-6 h-6 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Encontrar meu imóvel
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}"
                       class="btn-primary bg-white text-primary-600 hover:bg-neutral-600 px-8 py-4 text-lg font-semibold shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                        <svg class="w-6 h-6 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Criar conta gratuita
                    </a>
                    <a href="{{ route('properties.index.public') }}"
                       class="border-2 border-white text-white hover:bg-white hover:text-primary-600 px-8 py-4 rounded-xl text-lg font-semibold transition-all duration-300">
                        <svg class="w-6 h-6 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Ver imóveis
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

@auth
<script>
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
</script>
@endauth
@endsection
