@extends('layouts.app')

@section('title', 'Relatórios - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Relatórios</h1>
                    <p class="text-gray-600 mt-1">Análise detalhada do seu negócio imobiliário</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Relatório gerado em:</p>
                        <p class="text-sm font-medium text-gray-900">{{ now()->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-secondary-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                        📊
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Cards de Estatísticas Principais -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total de Imóveis -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total de Imóveis</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_properties']) }}</p>
                        <p class="text-xs text-green-600 mt-1">
                            +{{ $stats['properties_last_30_days'] }} nos últimos 30 dias
                        </p>
                    </div>
                </div>
            </div>

            <!-- Meus Imóveis -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Meus Imóveis</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['my_properties']) }}</p>
                        <p class="text-xs text-blue-600 mt-1">
                            {{ number_format($stats['my_active_properties']) }} ativos
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total de Visualizações -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total de Visualizações</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_views']) }}</p>
                        <p class="text-xs text-gray-600 mt-1">
                            {{ number_format($stats['my_views']) }} dos meus imóveis
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contatos Recebidos -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Contatos Recebidos</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['my_contacts']) }}</p>
                        <p class="text-xs text-red-600 mt-1">
                            {{ $stats['unread_contacts'] }} não lidos
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos e Análises Detalhadas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Propriedades por Categoria -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Propriedades por Categoria</h3>
                <div class="space-y-3">
                    @foreach($stats['properties_by_category'] as $category)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700">{{ $category->category_name }}</span>
                        <div class="flex items-center space-x-2">
                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                <div class="bg-primary-600 h-2 rounded-full"
                                     style="width: {{ $stats['total_properties'] > 0 ? ($category->count / $stats['total_properties']) * 100 : 0 }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 w-8 text-right">{{ $category->count }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Propriedades por Status -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status dos Imóveis</h3>
                <div class="space-y-3">
                    @foreach($stats['properties_by_status'] as $status)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700 capitalize">{{ $status->status }}</span>
                        <div class="flex items-center space-x-2">
                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                <div class="bg-secondary-600 h-2 rounded-full"
                                     style="width: {{ $stats['total_properties'] > 0 ? ($status->count / $stats['total_properties']) * 100 : 0 }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 w-8 text-right">{{ $status->count }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Estatísticas de Contatos e Visitas -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Contatos por Status -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Contatos por Status</h3>
                <div class="space-y-3">
                    @foreach($stats['contacts_by_status'] as $status)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700 capitalize">
                            @switch($status->status)
                                @case(\App\Models\Contact::STATUS_SENT)
                                    Enviados
                                    @break
                                @case(\App\Models\Contact::STATUS_REPLIED)
                                    Respondidos
                                    @break
                                @default
                                    {{ $status->status }}
                            @endswitch
                        </span>
                        <span class="text-sm font-medium text-gray-900">{{ $status->count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Visitas Agendadas - Desabilitado temporariamente --}}
            {{-- <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Visitas Agendadas</h3>
                <div class="text-center">
                    <div class="text-3xl font-bold text-primary-600 mb-2">{{ $stats['confirmed_visits'] }}</div>
                    <p class="text-sm text-gray-600">visitas confirmadas</p>
                    <div class="mt-4">
                        <div class="text-sm text-gray-500">Total de visitas</div>
                        <div class="text-lg font-semibold text-gray-900">{{ $stats['my_visits'] }}</div>
                    </div>
                </div>
            </div> --}}

            <!-- Atividade Recente -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Atividade dos Últimos 30 Dias</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-700">Novos imóveis</span>
                        <span class="text-sm font-medium text-green-600">+{{ $stats['properties_last_30_days'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-700">Novos contatos</span>
                        <span class="text-sm font-medium text-blue-600">+{{ $stats['contacts_last_30_days'] }}</span>
                    </div>
                    {{-- Novas visitas - Desabilitado temporariamente --}}
                    {{-- <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-700">Novas visitas</span>
                        <span class="text-sm font-medium text-purple-600">+{{ $stats['visits_last_30_days'] }}</span>
                    </div> --}}
                </div>
            </div>
        </div>

        <!-- Botão de Exportar -->
        <div class="flex justify-center">
            <button onclick="window.print()"
                    class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Exportar Relatório (PDF)
            </button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@media print {
    .no-print {
        display: none !important;
    }
    body {
        font-size: 12px;
    }
}
</style>
@endpush
