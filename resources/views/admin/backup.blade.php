@extends('layouts.app')

@section('title', 'Backup do Sistema - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Backup do Sistema</h1>
                    <p class="text-gray-600 mt-1">Gerencie backups de dados e arquivos</p>
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Criar Backup -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Criar Novo Backup</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Backup de Banco de Dados -->
                <div class="border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Banco de Dados</h3>
                            <p class="text-sm text-gray-600">Backup completo da base de dados SQLite</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.backup.create') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="type" value="database">
                        <button type="submit"
                                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition font-medium">
                            Criar Backup do Banco
                        </button>
                    </form>
                </div>

                <!-- Backup de Arquivos -->
                <div class="border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Arquivos</h3>
                            <p class="text-sm text-gray-600">Backup de imagens e arquivos enviados</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.backup.create') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="type" value="files">
                        <button type="submit"
                                class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition font-medium">
                            Criar Backup de Arquivos
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Backups Existentes -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Backups Existentes</h3>
            </div>

            @if(count($backups) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome do Arquivo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tamanho</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Criação</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($backups as $backup)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $backup['name'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if(str_contains($backup['name'], 'database')) bg-blue-100 text-blue-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ str_contains($backup['name'], 'database') ? 'Banco de Dados' : 'Arquivos' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($backup['size'] / 1024 / 1024, 2) }} MB
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ date('d/m/Y H:i', $backup['date']) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ url('storage/backups/' . $backup['name']) }}"
                                           class="text-blue-600 hover:text-blue-900" target="_blank">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                            </svg>
                                        </a>
                                        <button onclick="deleteBackup('{{ $backup['name'] }}')"
                                                class="text-red-600 hover:text-red-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                    <p class="text-gray-500 text-sm">Nenhum backup encontrado</p>
                    <p class="text-gray-400 text-xs mt-1">Crie seu primeiro backup usando os botões acima</p>
                </div>
            @endif
        </div>

        <!-- Informações sobre Backup -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-8">
            <div class="flex">
                <svg class="w-6 h-6 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-blue-800">Sobre os backups</h4>
                    <ul class="mt-2 text-sm text-blue-700 space-y-1">
                        <li>• <strong>Banco de dados:</strong> Salva uma cópia completa da base de dados SQLite</li>
                        <li>• <strong>Arquivos:</strong> Compacta todas as imagens e arquivos enviados pelos usuários</li>
                        <li>• <strong>Localização:</strong> Backups são salvos em <code>storage/backups/</code></li>
                        <li>• <strong>Recomendação:</strong> Faça backups regulares e armazene-os em local seguro</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteBackup(filename) {
    if (confirm(`Tem certeza que deseja excluir o backup "${filename}"?`)) {
        // Implementar exclusão de backup
        alert('Funcionalidade em desenvolvimento');
    }
}
</script>
@endsection
