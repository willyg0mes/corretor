@extends('layouts.app')

@section('title', 'Configurações - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Configurações</h1>
                    <p class="text-gray-600 mt-1">Gerencie suas preferências e informações pessoais</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Última atualização</p>
                        <p class="text-sm font-medium text-gray-900">{{ $user->updated_at?->format('d/m/Y H:i') ?? 'Nunca' }}</p>
                    </div>
                    <div class="w-12 h-12 bg-secondary-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                        ⚙️
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Formulário de Configurações -->
            <div class="lg:col-span-2">
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Informações Pessoais -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Informações Pessoais
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nome -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nome Completo</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('name') border-red-500 @enderror"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('email') border-red-500 @enderror"
                                       required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Telefone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('phone') border-red-500 @enderror"
                                       placeholder="(11) 99999-9999">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informações Profissionais -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Informações Profissionais
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- CRECI -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">CRECI</label>
                                <input type="text" name="creci" value="{{ old('creci', $user->creci) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('creci') border-red-500 @enderror"
                                       placeholder="Ex: 12345">
                                @error('creci')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tipo de Usuário (só leitura) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Conta</label>
                                <input type="text" value="{{ ucfirst($user->role) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-500" readonly>
                            </div>
                        </div>

                        <!-- Biografia -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Biografia/Sobre</label>
                            <textarea name="bio" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('bio') border-red-500 @enderror"
                                      placeholder="Conte um pouco sobre sua experiência no mercado imobiliário...">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Preferências de Notificação -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12V9a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2"/>
                            </svg>
                            Notificações
                        </h2>

                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="email_notifications" id="email_notifications" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                <label for="email_notifications" class="ml-3 text-sm text-gray-700">
                                    Receber notificações por e-mail sobre novos contatos
                                </label>
                            </div>

                            {{-- Notificações SMS - Desabilitado temporariamente --}}
                            {{-- <div class="flex items-center">
                                <input type="checkbox" name="sms_notifications" id="sms_notifications" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                <label for="sms_notifications" class="ml-3 text-sm text-gray-700">
                                    Receber notificações SMS sobre visitas agendadas
                                </label>
                            </div> --}}

                            <div class="flex items-center">
                                <input type="checkbox" name="marketing_emails" id="marketing_emails" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                <label for="marketing_emails" class="ml-3 text-sm text-gray-700">
                                    Receber e-mails de marketing e dicas do negócio
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Segurança -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Segurança
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Senha Atual</label>
                                <input type="password" name="current_password"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('current_password') border-red-500 @enderror">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nova Senha</label>
                                    <input type="password" name="password"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('password') border-red-500 @enderror">
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nova Senha</label>
                                    <input type="password" name="password_confirmation"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ações -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('dashboard') }}"
                           class="px-6 py-3 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition font-medium">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-6 py-3 text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition font-medium">
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sidebar com Informações -->
            <div class="lg:col-span-1">
                <!-- Status da Conta -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status da Conta</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Conta criada em:</span>
                            <span class="text-sm font-medium">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Último acesso:</span>
                            <span class="text-sm font-medium">{{ $user->last_login_at?->format('d/m/Y H:i') ?? 'Nunca' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Ativa
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Estatísticas Rápidas -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Seus Números</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Imóveis cadastrados:</span>
                            <span class="text-sm font-bold text-primary-600">{{ $user->properties()->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total de visualizações:</span>
                            <span class="text-sm font-bold text-purple-600">{{ $user->properties()->sum('views') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Contatos recebidos:</span>
                            <span class="text-sm font-bold text-green-600">{{ $user->receivedContacts()->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Dicas de Segurança -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <div class="flex">
                        <svg class="w-6 h-6 text-yellow-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-yellow-800">Dicas de Segurança</h4>
                            <ul class="mt-2 text-sm text-yellow-700 space-y-1">
                                <li>• Use uma senha forte e única</li>
                                <li>• Não compartilhe seus dados de acesso</li>
                                <li>• Mantenha seu CRECI atualizado</li>
                                <li>• Verifique regularmente seus contatos</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
