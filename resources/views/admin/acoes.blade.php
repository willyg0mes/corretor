@extends('layouts.app')

@section('title', 'Ações Administrativas - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Ações Administrativas</h1>
                    <p class="text-gray-600 mt-1">Ferramentas rápidas para gerenciamento do sistema</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Última atualização</p>
                        <p class="text-sm font-medium text-gray-900">{{ now()->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-accent-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                        ⚡
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Estatísticas Rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total de Usuários</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                        <p class="text-xs text-green-600 mt-1">{{ $stats['active_users'] }} ativos</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total de Imóveis</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_properties'] }}</p>
                        <p class="text-xs text-blue-600 mt-1">{{ $stats['active_properties'] }} ativos</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total de Contatos</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_contacts'] }}</p>
                        <p class="text-xs text-orange-600 mt-1">{{ $stats['pending_contacts'] }} pendentes</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total de Categorias</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
                        <p class="text-xs text-green-600 mt-1">{{ $stats['active_categories'] }} ativas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Ações Rápidas</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button onclick="limparCache()"
                        class="flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Limpar Cache
                </button>

                <button onclick="otimizarBanco()"
                        class="flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Otimizar Banco
                </button>

                <button onclick="gerarSitemap()"
                        class="flex items-center justify-center px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Gerar Sitemap
                </button>
            </div>
        </div>

        <!-- Status do Sistema -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Informações do Sistema -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações do Sistema</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Versão do PHP</span>
                        <span class="text-sm font-medium">{{ PHP_VERSION }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Versão do Laravel</span>
                        <span class="text-sm font-medium">{{ app()->version() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Banco de Dados</span>
                        <span class="text-sm font-medium">SQLite</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Ambiente</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Produção
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Cache</span>
                        <span class="text-sm font-medium">File System</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Última atualização</span>
                        <span class="text-sm font-medium">{{ now()->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Atividades Recentes -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Atividades Recentes</h3>
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-2 h-2 bg-green-400 rounded-full mt-2"></div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-900">Sistema inicializado com sucesso</p>
                            <p class="text-xs text-gray-500">{{ now()->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-2 h-2 bg-blue-400 rounded-full mt-2"></div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-900">Backup automático realizado</p>
                            <p class="text-xs text-gray-500">{{ now()->subHours(2)->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-2 h-2 bg-yellow-400 rounded-full mt-2"></div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-900">Novo usuário registrado</p>
                            <p class="text-xs text-gray-500">{{ now()->subHours(4)->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-2 h-2 bg-purple-400 rounded-full mt-2"></div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-900">Imóvel aprovado para publicação</p>
                            <p class="text-xs text-gray-500">{{ now()->subHours(6)->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function limparCache() {
    if (confirm('Tem certeza que deseja limpar o cache do sistema?')) {
        fetch('/admin/cache/clear', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message || 'Cache limpo com sucesso!');
            location.reload();
        })
        .catch(error => {
            alert('Erro ao limpar cache: ' + error.message);
        });
    }
}

function otimizarBanco() {
    if (confirm('Tem certeza que deseja otimizar o banco de dados?')) {
        alert('Funcionalidade em desenvolvimento');
    }
}

function gerarSitemap() {
    if (confirm('Tem certeza que deseja gerar um novo sitemap?')) {
        alert('Funcionalidade em desenvolvimento');
    }
}
</script>
@endsection
