@extends('layouts.app')

@section('title', 'Relatórios Administrativos - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Relatórios Administrativos</h1>
                    <p class="text-gray-600 mt-1">Análises completas do sistema</p>
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
        <!-- Métricas Principais -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Usuários -->
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
                        <p class="text-xs text-green-600 mt-1">+{{ $stats['new_users_last_30'] }} últimos 30 dias</p>
                    </div>
                </div>
            </div>

            <!-- Imóveis -->
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
                        <p class="text-xs text-blue-600 mt-1">+{{ $stats['new_properties_last_30'] }} últimos 30 dias</p>
                    </div>
                </div>
            </div>

            <!-- Contatos -->
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
                        <p class="text-xs text-orange-600 mt-1">+{{ $stats['new_contacts_last_30'] }} últimos 30 dias</p>
                    </div>
                </div>
            </div>

            <!-- Visitas -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total de Visitas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_visits'] }}</p>
                        <p class="text-xs text-pink-600 mt-1">+{{ $stats['new_visits_last_30'] }} últimos 30 dias</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos e Análises -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Usuários por Role -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Usuários por Tipo</h3>
                <div class="space-y-3">
                    @foreach($stats['users_by_role'] as $role)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700 capitalize">{{ $role->role }}</span>
                        <div class="flex items-center space-x-2">
                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full"
                                     style="width: {{ $stats['total_users'] > 0 ? ($role->count / $stats['total_users']) * 100 : 0 }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 w-8 text-right">{{ $role->count }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Imóveis por Status -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Imóveis por Status</h3>
                <div class="space-y-3">
                    @foreach($stats['properties_by_status'] as $status)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700 capitalize">{{ $status->status }}</span>
                        <div class="flex items-center space-x-2">
                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full"
                                     style="width: {{ $stats['total_properties'] > 0 ? ($status->count / $stats['total_properties']) * 100 : 0 }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 w-8 text-right">{{ $status->count }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Imóveis por Tipo -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Imóveis por Tipo</h3>
                <div class="space-y-3">
                    @foreach($stats['properties_by_type'] as $type)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700 capitalize">{{ $type->type }}</span>
                        <div class="flex items-center space-x-2">
                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full"
                                     style="width: {{ $stats['total_properties'] > 0 ? ($type->count / $stats['total_properties']) * 100 : 0 }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 w-8 text-right">{{ $type->count }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Imóveis por Estado -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Imóveis por Estado</h3>
                <div class="space-y-3">
                    @foreach($stats['properties_by_state'] as $state)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700">{{ $state->state }}</span>
                        <div class="flex items-center space-x-2">
                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                <div class="bg-red-600 h-2 rounded-full"
                                     style="width: {{ $stats['total_properties'] > 0 ? ($state->count / $stats['total_properties']) * 100 : 0 }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 w-8 text-right">{{ $state->count }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Usuários Mais Ativos -->
        <div class="bg-white rounded-lg shadow-sm p-6 mt-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Usuários Mais Ativos (Top 10)</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuário</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imóveis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contatos</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pontuação</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($stats['most_active_users'] as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user->properties_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user->received_contacts_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                {{ $user->properties_count + $user->received_contacts_count }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Categorias Mais Utilizadas -->
        <div class="bg-white rounded-lg shadow-sm p-6 mt-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Categorias Mais Utilizadas</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($stats['categories_usage'] as $category)
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">{{ $category->icon }}</span>
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                            <div class="text-xs text-gray-500">{{ $category->properties_count }} imóveis</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-bold text-blue-600">{{ $category->properties_count }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
