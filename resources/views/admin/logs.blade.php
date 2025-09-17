@extends('layouts.app')

@section('title', 'Logs do Sistema - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Logs do Sistema</h1>
                    <p class="text-gray-600 mt-1">Visualize e baixe os logs de erro da aplicação</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.logs.download') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        </svg>
                        Baixar Logs
                    </a>
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filtros de Logs -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-48">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nível do Log</label>
                    <select id="logLevel" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Todos os níveis</option>
                        <option value="EMERGENCY">EMERGENCY</option>
                        <option value="ALERT">ALERT</option>
                        <option value="CRITICAL">CRITICAL</option>
                        <option value="ERROR">ERROR</option>
                        <option value="WARNING">WARNING</option>
                        <option value="NOTICE">NOTICE</option>
                        <option value="INFO">INFO</option>
                        <option value="DEBUG">DEBUG</option>
                    </select>
                </div>

                <div class="flex-1 min-w-48">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buscar no Log</label>
                    <input type="text" id="logSearch" placeholder="Buscar por palavra-chave..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div class="flex items-center space-x-2">
                    <button onclick="filterLogs()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Filtrar
                    </button>
                    <button onclick="clearFilters()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                        Limpar
                    </button>
                </div>
            </div>
        </div>

        <!-- Logs -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Últimas 100 entradas do log</h3>
                <button onclick="refreshLogs()"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Atualizar
                </button>
            </div>

            <div class="p-6">
                @if(count($logs) > 0)
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        @foreach($logs as $log)
                        <div class="border-l-4 border-gray-300 pl-4 py-2 log-entry">
                            <div class="text-sm text-gray-600 font-mono break-all">{{ $log }}</div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-500 text-sm">Nenhum log encontrado</p>
                        <p class="text-gray-400 text-xs mt-1">Os logs aparecerão aqui quando houver atividade no sistema</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Informações sobre Logs -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
            <!-- Sobre Logs -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex">
                    <svg class="w-6 h-6 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-blue-800">Sobre os logs</h4>
                        <ul class="mt-2 text-sm text-blue-700 space-y-1">
                            <li>• Logs ajudam a identificar e resolver problemas</li>
                            <li>• São salvos automaticamente em <code>storage/logs/</code></li>
                            <li>• Contêm informações de erros, warnings e atividades</li>
                            <li>• São rotacionados automaticamente para evitar acúmulo</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Estatísticas de Logs -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex">
                    <svg class="w-6 h-6 text-green-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-green-800">Estatísticas</h4>
                        <div class="mt-2 text-sm text-green-700">
                            <p>Total de entradas: <strong>{{ count($logs) }}</strong></p>
                            <p>Arquivo: <code>laravel.log</code></p>
                            <p>Última atualização: <strong>{{ now()->format('d/m/Y H:i:s') }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterLogs() {
    const level = document.getElementById('logLevel').value.toLowerCase();
    const search = document.getElementById('logSearch').value.toLowerCase();

    const logEntries = document.querySelectorAll('.log-entry');

    logEntries.forEach(entry => {
        const text = entry.textContent.toLowerCase();
        let show = true;

        if (level && !text.includes(`[${level.toUpperCase()}]`)) {
            show = false;
        }

        if (search && !text.includes(search)) {
            show = false;
        }

        entry.style.display = show ? 'block' : 'none';
    });
}

function clearFilters() {
    document.getElementById('logLevel').value = '';
    document.getElementById('logSearch').value = '';

    const logEntries = document.querySelectorAll('.log-entry');
    logEntries.forEach(entry => {
        entry.style.display = 'block';
    });
}

function refreshLogs() {
    location.reload();
}
</script>
@endsection
