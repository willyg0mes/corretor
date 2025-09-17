@extends('layouts.app')

@section('title', 'Configurações do Sistema - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Configurações do Sistema</h1>
                    <p class="text-gray-600 mt-1">Configure as definições gerais da aplicação</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.acoes') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Configurações do Sistema -->
        <form action="{{ route('admin.configuracoes.save') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Informações Básicas -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informações Básicas
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nome da Aplicação</label>
                        <input type="text" name="app_name" value="{{ $config['app_name'] }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('app_name') border-red-500 @enderror"
                               required>
                        @error('app_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">URL da Aplicação</label>
                        <input type="url" name="app_url" value="{{ $config['app_url'] }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('app_url') border-red-500 @enderror"
                               required>
                        @error('app_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                        <select name="timezone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('timezone') border-red-500 @enderror">
                            <option value="America/Sao_Paulo" {{ $config['timezone'] === 'America/Sao_Paulo' ? 'selected' : '' }}>America/Sao_Paulo</option>
                            <option value="UTC" {{ $config['timezone'] === 'UTC' ? 'selected' : '' }}>UTC</option>
                        </select>
                        @error('timezone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Idioma</label>
                        <select name="locale" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('locale') border-red-500 @enderror">
                            <option value="pt_BR" {{ $config['locale'] === 'pt_BR' ? 'selected' : '' }}>Português (Brasil)</option>
                            <option value="en" {{ $config['locale'] === 'en' ? 'selected' : '' }}>English</option>
                        </select>
                        @error('locale')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Modo de Manutenção -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    Modo de Manutenção
                </h2>

                <div class="flex items-center">
                    <input type="checkbox" name="maintenance_mode" value="1" id="maintenance_mode"
                           {{ isset($config['maintenance_mode']) && $config['maintenance_mode'] ? 'checked' : '' }}
                           class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                    <label for="maintenance_mode" class="ml-3 flex items-center text-sm font-medium text-gray-700">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        Ativar modo de manutenção
                        <span class="ml-2 text-xs text-gray-500 bg-red-100 px-2 py-1 rounded">Bloqueia acesso público</span>
                    </label>
                </div>

                <div class="mt-4 p-4 bg-yellow-50 rounded-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-yellow-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-yellow-800">Atenção</h4>
                            <p class="mt-1 text-sm text-yellow-700">
                                O modo de manutenção bloqueará o acesso público à aplicação. Apenas administradores poderão acessar o sistema.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cache e Otimizações -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Cache e Otimizações
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <button type="button" onclick="clearCache()"
                            class="flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Limpar Cache
                    </button>

                    <button type="button" onclick="clearViews()"
                            class="flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Limpar Views
                    </button>

                    <button type="button" onclick="optimizeApp()"
                            class="flex items-center justify-center px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Otimizar App
                    </button>
                </div>
            </div>

            <!-- Ações -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.acoes') }}"
                   class="px-6 py-3 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition font-medium">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-3 text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition font-medium">
                    Salvar Configurações
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function clearCache() {
    if (confirm('Tem certeza que deseja limpar todo o cache da aplicação?')) {
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
        })
        .catch(error => {
            alert('Erro ao limpar cache: ' + error.message);
        });
    }
}

function clearViews() {
    if (confirm('Tem certeza que deseja limpar o cache de views?')) {
        alert('Funcionalidade em desenvolvimento');
    }
}

function optimizeApp() {
    if (confirm('Tem certeza que deseja otimizar a aplicação?')) {
        alert('Funcionalidade em desenvolvimento');
    }
}
</script>
@endsection
