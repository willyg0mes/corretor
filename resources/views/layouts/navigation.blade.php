<nav x-data="{ open: false, searchOpen: false }" class="bg-white/95 backdrop-blur-sm shadow-soft border-b border-gray-200 py-4 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-18">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="bg-primary-600 text-white p-3 rounded-xl shadow-lg group-hover:shadow-xl transition-all duration-300 animate-bounce-subtle">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xl font-bold text-gray-900 leading-tight group-hover:text-primary-600 transition-colors">Alaor</span>
                            <span class="text-xs text-secondary-600 font-semibold tracking-wide uppercase">Corretor de Imóveis</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex md:items-center md:space-x-1 md:ml-12">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <span class="relative">
                            Início
                            @if(request()->routeIs('home'))
                                <div class="absolute -bottom-1 left-0 right-0 h-0.5 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full"></div>
                            @endif
                        </span>
                    </a>

                    @auth
                        <a href="{{ route('properties.index.public') }}" class="nav-link {{ request()->routeIs('properties.index.public') || request()->routeIs('properties.*') && !request()->routeIs('properties.create') ? 'active' : '' }}">
                            <span class="relative">
                                Imóveis
                                @if(request()->routeIs('properties.*') && !request()->routeIs('properties.create'))
                                    <div class="absolute -bottom-1 left-0 right-0 h-0.5 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full"></div>
                                @endif
                            </span>
                        </a>

                        @if(auth()->user()->isCorretor())
                            <a href="{{ route('properties.create') }}" class="bg-gradient-to-r from-accent-500 to-accent-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:from-accent-600 hover:to-accent-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 ml-4">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Anunciar
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center space-x-4">
                <!-- Search Bar (Desktop) -->
                <div class="hidden md:block">
                    <form action="{{ route('properties.index.public') }}" method="GET" class="flex">
                        <div class="relative">
                            <input type="text" name="search" placeholder="Buscar imóveis..."
                                   class="w-72 pl-4 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 bg-gray-50 hover:bg-white shadow-sm">
                            <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-primary-600 text-white p-2 rounded-lg hover:bg-primary-700 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Mobile Search Toggle -->
                <button @click="searchOpen = !searchOpen" class="md:hidden text-gray-600 hover:text-primary-600 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                @guest
                    <div class="hidden md:flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary-600 px-4 py-2 text-sm font-medium transition-colors duration-200">
                            Entrar
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary">
                            Cadastrar
                        </a>
                    </div>
                @endguest

                @auth
                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-3 text-gray-700 hover:text-primary-600 focus:outline-none p-2 rounded-lg hover:bg-gray-100 transition-all duration-200" x-tooltip="Menu do usuário">
                            <div class="w-9 h-9 bg-gradient-to-br from-primary-500 to-secondary-600 rounded-full flex items-center justify-center text-white text-sm font-semibold shadow-md">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="hidden md:block text-sm font-medium">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute right-0 mt-3 w-72 bg-white rounded-xl shadow-large ring-1 ring-black ring-opacity-5 z-50 overflow-hidden">
                            <div class="bg-gradient-to-r from-primary-50 to-secondary-50 px-4 py-3 border-b border-gray-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-secondary-600 rounded-full flex items-center justify-center text-white text-lg font-semibold shadow-md">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-600">{{ auth()->user()->email }}</p>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium capitalize
                                            {{ auth()->user()->isAdmin() ? 'bg-accent-100 text-accent-800' :
                                               (auth()->user()->isCorretor() ? 'bg-primary-100 text-primary-800' : 'bg-secondary-100 text-secondary-800') }}">
                                            {{ auth()->user()->role }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="py-2">
                                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Dashboard
                                </a>

                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Perfil
                                </a>

                                @if(auth()->user()->isCorretor())
                                    <a href="{{ route('properties.create') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-accent-50 hover:text-accent-700 transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-3 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Anunciar Imóvel
                                    </a>
                                @endif

                                <a href="{{ route('properties.favorites') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-secondary-50 hover:text-secondary-700 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    Favoritos
                                </a>
                            </div>

                            <div class="border-t border-gray-200">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Mobile Search Bar -->
        <div x-show="searchOpen" x-transition class="md:hidden pb-4">
            <form action="{{ route('properties.index.public') }}" method="GET" class="flex">
                <input type="text" name="search" placeholder="Buscar imóveis..."
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="open" @click.away="open = false" x-transition
         class="md:hidden bg-white border-t border-gray-200 shadow-lg">

        <!-- Guest Menu -->
        @guest
            <div class="px-4 py-3 border-b border-gray-200">
                <a href="{{ route('login') }}" class="block w-full text-center bg-orange-500 text-white px-4 py-2 rounded text-sm font-medium hover:bg-orange-600 transition mb-2">
                    Entrar
                </a>
                <a href="{{ route('register') }}" class="block w-full text-center text-orange-500 px-4 py-2 text-sm font-medium">
                    Cadastrar
                </a>
            </div>
        @endguest

        <!-- Authenticated Menu -->
        @auth
            <div class="px-4 py-3 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                </div>
            </div>

            <div class="py-2">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Dashboard
                </a>
                <a href="{{ route('properties.index.public') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Imóveis
                </a>

                @if(auth()->user()->isCorretor())
                    <a href="{{ route('properties.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Anunciar Imóvel
                    </a>
                @endif

                <a href="{{ route('properties.favorites') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Favoritos
                </a>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Perfil
                </a>
            </div>

            <div class="border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                        Sair
                    </button>
                </form>
            </div>
        @endauth
    </div>
</nav>