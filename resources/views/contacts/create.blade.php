@extends('layouts.app')

@section('title', 'Contatar Corretor - ' . $property->title)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center mb-4">
                <a href="{{ route('properties.show', $property) }}" class="text-primary-600 hover:text-primary-700 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Contatar Corretor</h1>
                    <p class="text-gray-600">{{ $property->title }}</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <form action="{{ route('contacts.store', $property) }}" method="POST">
                @csrf
                <input type="hidden" name="property_id" value="{{ $property->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                        <input type="text" name="name" required
                               value="{{ old('name') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">E-mail *</label>
                        <input type="email" name="email" required
                               value="{{ old('email') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telefone *</label>
                    <input type="tel" name="phone" required
                           value="{{ old('phone') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mensagem *</label>
                    <textarea name="message" rows="6" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 @error('message') border-red-500 @enderror"
                              placeholder="Conte ao corretor por que você está interessado neste imóvel...">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('properties.show', $property) }}"
                       class="px-6 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-2 text-sm font-medium text-white bg-primary-600 rounded-md hover:bg-primary-700 transition">
                        Enviar Mensagem
                    </button>
                </div>
            </form>
        </div>

        <!-- Informações do Corretor -->
        <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Sobre o Corretor</h3>
            <div class="flex items-center">
                <div class="w-12 h-12 bg-primary-500 rounded-full flex items-center justify-center text-white text-lg font-bold mr-4">
                    {{ substr($property->user->name, 0, 1) }}
                </div>
                <div>
                    <p class="font-medium text-gray-900">{{ $property->user->name }}</p>
                    <p class="text-gray-600">Corretor de Imóveis</p>
                    @if($property->user->phone)
                    <p class="text-gray-600">{{ $property->user->formatted_phone }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
