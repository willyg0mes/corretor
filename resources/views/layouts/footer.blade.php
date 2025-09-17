<footer class="bg-gray-100 border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="bg-orange-500 text-white p-2 rounded">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-bold text-gray-900 leading-tight">Alaor</span>
                        <span class="text-xs text-orange-500 font-medium">Corretor de Imóveis</span>
                    </div>
                </div>
                <p class="text-gray-600 text-sm">
                    Plataforma completa para compra e aluguel de imóveis.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-4 uppercase tracking-wider">Links Úteis</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-600 transition text-sm">Página Inicial</a></li>
                    <li><a href="{{ route('properties.index.public') }}" class="text-gray-600 hover:text-primary-600 transition text-sm">Buscar Imóveis</a></li>
                    @auth
                        @if(auth()->user()->isCorretor())
                            <li><a href="{{ route('properties.create') }}" class="text-gray-600 hover:text-accent-600 transition text-sm">Anunciar Imóvel</a></li>
                        @endif
                        <li><a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-primary-600 transition text-sm">Minha Conta</a></li>
                    @endauth
                    @guest
                        <li><a href="{{ route('register') }}" class="text-gray-600 hover:text-secondary-600 transition text-sm">Cadastrar</a></li>
                    @endguest
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-4 uppercase tracking-wider">Suporte</h3>
                <ul class="space-y-2">
                    <li><a href="https://wa.me/556294640321?text=Olá!%20Preciso%20de%20ajuda%20com%20a%20plataforma%20de%20imóveis." target="_blank" class="text-gray-600 hover:text-primary-600 transition text-sm">Central de Ajuda</a></li>
                    <li><a href="{{ route('termos-de-uso') }}" class="text-gray-600 hover:text-primary-600 transition text-sm">Termos de Uso</a></li>
                    <li><a href="{{ route('politica-de-privacidade') }}" class="text-gray-600 hover:text-primary-600 transition text-sm">Política de Privacidade</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-200 mt-8 pt-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} Alaor - Corretor Imóveis. Todos os direitos reservados.</p>
                <p class="text-gray-500 text-sm">Desenvolvido por <a href="https://www.linkedin.com/in/willy-g-163874207/" class="text-primary-600 hover:text-primary-700 transition">Willy Gomes</a></p>
            </div>
        </div>
    </div>
</footer>
