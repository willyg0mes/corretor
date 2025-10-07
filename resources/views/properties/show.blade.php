@extends('layouts.app')

@section('title', $property->title . ' - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header com breadcrumb -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-9 9a1 1 0 001.414 1.414L2 12.414V18a1 1 0 001 1h4a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h4a1 1 0 00-1-1v-5.586l.293.293a1 1 0 001.414-1.414l-9-9z"/>
                                </svg>
                                <span class="sr-only">Home</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <a href="{{ route('properties.index.public') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Imóveis</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-700">{{ $property->category->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Grid principal: Anúncio (2 colunas) | Corretor (1 coluna) -->
        <div>
            <!-- Coluna 1-2: Conteúdo do anúncio -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Galeria Avançada -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                    @php
                        $allMedia = collect();
                        $property->images->each(function($image) use (&$allMedia) {
                            $allMedia->push([
                                'id' => $image->id,
                                'type' => 'image',
                                'url' => $image->url,
                                'thumbnail' => $image->thumbnail_url,
                                'alt' => $image->alt_text ?? $image->filename,
                                'title' => $image->alt_text ?? 'Imagem do imóvel'
                            ]);
                        });
                        $property->videos->each(function($video) use (&$allMedia) {
                            $allMedia->push([
                                'id' => $video->id,
                                'type' => 'video',
                                'url' => $video->url,
                                'thumbnail' => $video->thumbnail_url,
                                'alt' => $video->alt_text ?? $video->filename,
                                'title' => $video->alt_text ?? 'Vídeo do imóvel',
                                'duration' => $video->duration_formatted
                            ]);
                        });
                    @endphp


                    @if($allMedia->isEmpty())
                        <div class="aspect-w-16 aspect-h-9 bg-gray-100 flex items-center justify-center">
                            <div class="text-center text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-lg font-medium">Nenhuma imagem ou vídeo disponível</p>
                                <p class="text-sm">Este imóvel ainda não possui mídia cadastrada.</p>
                            </div>
                        </div>
                    @else
                    <div class="flex gap-4" x-data="propertyGallery({
                        media: {{ $allMedia->toJson() }},
                        currentIndex: 0,
                        showLightbox: false,
                        zoomLevel: 1,
                        isDragging: false,
                        dragStart: { x: 0, y: 0 },
                        imagePosition: { x: 0, y: 0 }
                    })"

                        <!-- Miniaturas à Esquerda (estilo Mercado Livre) -->
                        <div class="w-20 flex flex-col space-y-2">
                            <template x-for="(item, index) in media" :key="item.id">
                                <button @click="currentIndex = index"
                                        :class="currentIndex === index ? 'ring-2 ring-primary-500 ring-offset-2' : 'hover:ring-2 hover:ring-gray-300 hover:ring-offset-1'"
                                        class="relative rounded-lg overflow-hidden transition-all duration-200 flex-shrink-0 focus:outline-none">
                                    <div class="w-20 h-20 bg-gray-200 relative">
                                        <template x-if="item.type === 'image'">
                                            <img :src="item.thumbnail || item.url"
                                                 :alt="item.alt"
                                                 class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="item.type === 'video'">
                                            <video :src="item.url"
                                                   muted
                                                   class="w-full h-full object-cover"
                                                   preload="metadata"
                                                   loop>
                                                <img :src="item.thumbnail"
                                                     :alt="item.alt"
                                                     class="w-full h-full object-cover">
                                            </video>
                                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-20">
                                                <div class="w-6 h-6 bg-black bg-opacity-60 rounded-full flex items-center justify-center">
                                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M8 5v14l11-7z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </template>
                                        <!-- Indicador de item ativo -->
                                        <div x-show="currentIndex === index"
                                             class="absolute bottom-1 right-1 w-4 h-4 bg-primary-500 rounded-full flex items-center justify-center">
                                            <span class="text-white text-xs font-bold" x-text="(index + 1)"></span>
                                        </div>
                                    </div>
                                </button>
                            </template>
                        </div>

                        <!-- Imagem/Vídeo Principal à Direita -->
                        <div class="flex-1 relative">
                            <div class="relative w-full h-full bg-gray-100">

                                <template x-if="currentMedia.type === 'image'">
                                    <div @click="openLightbox()"
                                         class="w-full h-full cursor-zoom-in transition-transform duration-200 hover:scale-105 relative">
                                        <img :src="currentMedia.url"
                                             :alt="currentMedia.alt"
                                             class="w-full h-full object-cover"
                                             x-ref="mainImage">
                                    </div>
                                </template>

                                <template x-if="currentMedia.type === 'video'">
                                    <div class="custom-video-player"
                                         x-data="customVideoPlayer(currentMedia.url)"
                                         x-init="initPlayer()">
                                        <video x-ref="video"
                                               :src="videoSrc"
                                               preload="metadata"
                                               playsinline
                                               @loadedmetadata="onLoadedMetadata"
                                               @timeupdate="onTimeUpdate"
                                               @progress="onProgress"
                                               @ended="onEnded"
                                               @play="onPlay"
                                               @pause="onPause"></video>

                                        <!-- Loading Spinner -->
                                        <div class="custom-video-loading" x-show="isLoading" x-transition></div>

                                        <!-- Custom Controls -->
                                        <div class="custom-video-controls">
                                            <!-- Play/Pause -->
                                            <button class="play-button" @click="togglePlay()" :title="isPlaying ? 'Pausar' : 'Reproduzir'">
                                                <svg class="icon" x-show="!isPlaying" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                                <svg class="icon" x-show="isPlaying" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                                                </svg>
                                            </button>

                                            <!-- Time Display -->
                                            <div class="time-display">
                                                <span x-text="formatTime(currentTime)"></span> /
                                                <span x-text="formatTime(duration)"></span>
                                            </div>

                                            <!-- Progress Bar -->
                                            <div class="progress-container" @click="seek($event)">
                                                <div class="progress-buffer" :style="'width: ' + buffered + '%'"></div>
                                                <div class="progress-bar" :style="'width: ' + progress + '%'"></div>
                                            </div>

                                            <!-- Volume Control -->
                                            <div class="volume-container">
                                                <button @click="toggleMute()" :title="isMuted ? 'Ativar som' : 'Desativar som'">
                                                    <svg class="icon" x-show="!isMuted && volume > 0.5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
                                                    </svg>
                                                    <svg class="icon" x-show="!isMuted && volume > 0 && volume <= 0.5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M18.5 12c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM5 9v6h4l5 5V4L9 9H5z"/>
                                                    </svg>
                                                    <svg class="icon" x-show="isMuted || volume === 0" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v1.79l2.48 2.48c.01-.08.02-.16.02-.24zm-6.5 0c0 .75.16 1.46.44 2.11l1.56-1.56L10.5 12zm6.5-6.5c-2.34 0-4.36.88-5.83 2.21l1.42 1.42C12.54 8.69 14.14 8.5 15.5 8.5c1.93 0 3.67.78 4.89 2.05l1.41-1.41C19.73 6.45 17.78 5.5 15.5 5.5zm-8.35 3.15l1.41 1.41C6.16 10.19 5.5 11.06 5.5 12s.66 1.81 1.76 2.34l-1.41 1.41C4.26 14.34 3.5 13.25 3.5 12s.76-2.34 2.15-3.35z"/>
                                                    </svg>
                                                </button>
                                                <div class="volume-slider" @click="setVolume($event)">
                                                    <div class="volume-level" :style="'width: ' + (isMuted ? 0 : volume * 100) + '%'"></div>
                                                </div>
                                            </div>

                                            <!-- Fullscreen -->
                                            <button class="fullscreen-button" @click="toggleFullscreen()" title="Tela cheia">
                                                <svg class="icon" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>

                                <!-- Overlay de Zoom (apenas para imagens) -->
                                <div class="absolute top-2 right-2 bg-black bg-opacity-60 text-white px-2 py-1 rounded-full text-xs flex items-center space-x-1"
                                     x-show="currentMedia.type === 'image'">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <span>Clique para ampliar</span>
                                </div>

                                <!-- Contador para imagens (canto superior esquerdo, abaixo dos badges) -->
                                <div class="absolute top-12 left-2 bg-black bg-opacity-60 text-white px-2 py-1 rounded-full text-xs"
                                     x-show="currentMedia.type === 'image'">
                                    <span x-text="(currentIndex + 1) + ' / ' + media.length"></span>
                                </div>

                                <!-- Contador para vídeos (canto superior direito, sem sobrepor badges) -->
                                <div class="absolute top-12 right-2 bg-black bg-opacity-60 text-white px-2 py-1 rounded-full text-xs"
                                     x-show="currentMedia.type === 'video'">
                                    <span x-text="(currentIndex + 1) + ' / ' + media.length"></span>
                                </div>

                                <!-- Navegação para imagens -->
                                <div class="absolute inset-y-0 left-0 right-0 flex items-center justify-between px-4"
                                     x-show="media.length > 1 && currentMedia.type === 'image'">
                                    <button @click="previousMedia()"
                                            class="bg-black bg-opacity-50 hover:bg-opacity-75 text-white p-2 rounded-full transition-all transform hover:scale-110">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </button>

                                    <button @click="nextMedia()"
                                            class="bg-black bg-opacity-50 hover:bg-opacity-75 text-white p-2 rounded-full transition-all transform hover:scale-110">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Navegação para vídeos (no topo) -->
                                <div class="absolute top-2 left-0 right-0 flex items-center justify-between px-4"
                                     x-show="media.length > 1 && currentMedia.type === 'video'">
                                    <button @click="previousMedia()"
                                            class="bg-black bg-opacity-70 hover:bg-opacity-90 text-white p-2 rounded-full transition-all transform hover:scale-110">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </button>

                                    <button @click="nextMedia()"
                                            class="bg-black bg-opacity-70 hover:bg-opacity-90 text-white p-2 rounded-full transition-all transform hover:scale-110">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        <!-- Badges -->
                        <div class="absolute top-4 left-4 flex flex-col space-y-2">
                            @if($property->featured)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-accent-500 text-white shadow-lg">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                Destaque
                            </span>
                            @endif
                            @if($property->urgent)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-500 text-white shadow-lg">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                Urgente
                            </span>
                            @endif
                            @if($property->type === 'venda')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-500 text-white shadow-lg">
                                À Venda
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-secondary-500 text-white shadow-lg">
                                Para Alugar
                            </span>
                            @endif
                        </div>


                        <!-- Lightbox Modal -->
                        <div x-show="showLightbox"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center"
                             @keydown.escape.window="closeLightbox()"
                             @keydown.arrow-left.window="previousMedia()"
                             @keydown.arrow-right.window="nextMedia()"
                             style="z-index: 9999;">

                            <!-- Close Button -->
                            <button @click="closeLightbox()"
                                    class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors z-10">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>

                            <!-- Navigation Arrows -->
                            <button x-show="media.length > 1"
                                    @click="previousMedia()"
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 transition-colors">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>

                            <button x-show="media.length > 1"
                                    @click="nextMedia()"
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300 transition-colors">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>

                            <!-- Media Content -->
                            <div class="relative max-w-5xl max-h-screen p-4">
                                <template x-if="currentMedia.type === 'image'">
                                    <img :src="currentMedia.url"
                                         :alt="currentMedia.alt"
                                         class="max-w-full max-h-full object-contain"
                                         x-ref="lightboxImage"
                                         @mousedown="startDrag($event)"
                                         @mousemove="drag($event)"
                                         @mouseup="stopDrag()"
                                         @wheel="handleZoom($event)">
                                </template>

                                <template x-if="currentMedia.type === 'video'">
                                    <div class="relative">
                                        <video x-ref="lightboxVideo"
                                               :src="currentMedia.url"
                                               controls
                                               class="max-w-full max-h-screen object-contain"
                                               x-init="$el.load()">
                                        </video>
                                    </div>
                                </template>
                            </div>


                            <!-- Zoom Controls -->
                            <div x-show="currentMedia.type === 'image' && showLightbox"
                                 class="absolute bottom-4 right-4 bg-black bg-opacity-60 rounded-lg p-2 flex space-x-2">
                                <button @click="zoomIn()"
                                        class="text-white hover:text-gray-300 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </button>
                                <span class="text-white text-sm self-center" x-text="Math.round(zoomLevel * 100) + '%'"></span>
                                <button @click="zoomOut()"
                                        class="text-white hover:text-gray-300 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                    </svg>
                                </button>
                                <button @click="resetZoom()"
                                        class="text-white hover:text-gray-300 transition-colors ml-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                    @endif

                <!-- Informações principais -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $property->title }}</h1>

                            <!-- Status do imóvel (vendido/alugado) -->
                            @if($property->status === 'vendido' || $property->status === 'alugado')
                            <div class="mb-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $property->status === 'vendido' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        @if($property->status === 'vendido')
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        @else
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        @endif
                                    </svg>
                                    Imóvel {{ $property->status === 'vendido' ? 'Vendido' : 'Alugado' }}
                                </span>
                            </div>
                            @endif

                            <p class="text-gray-600 flex items-center">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $property->address }}, {{ $property->city }} - {{ $property->state }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-primary-600">
                                R$ {{ number_format($property->numeric_price, 0, ',', '.') }}
                                @if($property->type === 'aluguel')
                                <span class="text-sm font-normal text-gray-500">/mês</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Características principais -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        @if($property->bedrooms > 0)
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="text-sm text-gray-600">{{ $property->bedrooms }} quartos</span>
                        </div>
                        @endif

                        @if($property->bathrooms > 0)
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <span class="text-sm text-gray-600">{{ $property->bathrooms }} banheiros</span>
                        </div>
                        @endif

                        @if($property->parking_spaces > 0)
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span class="text-sm text-gray-600">{{ $property->parking_spaces }} vagas</span>
                        </div>
                        @endif

                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-sm text-gray-600">{{ $property->area }}m²</span>
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Descrição</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $property->description }}</p>
                    </div>
                </div>

                <!-- Características e comodidades -->
                @if($property->features || $property->amenities)
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Características e Comodidades</h3>

                    @if($property->features)
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Características Internas</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($property->features as $feature)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-primary-100 text-primary-800">
                                {{ $feature }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($property->amenities)
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Comodidades do Condomínio</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($property->amenities as $amenity)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-secondary-100 text-secondary-800">
                                {{ $amenity }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Coluna 3: Corretor -->
            <div class="lg:col-span-1">
                <!-- Card do corretor -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6 sticky top-6">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-primary-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                            {{ substr($corretorPrincipal->name, 0, 1) }}
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $corretorPrincipal->name }}</h3>
                        <p class="text-gray-600">Corretor de Imóveis</p>
                        @if($corretorPrincipal->phone)
                        <p class="text-gray-600 mt-2">{{ $corretorPrincipal->formatted_phone }}</p>
                        @endif
                        @if($corretorPrincipal->creci)
                        <p class="text-sm text-gray-500 mt-1">CRECI: {{ $corretorPrincipal->creci }}</p>
                        @endif
                    </div>

                    <!-- Ações -->
                    <div class="space-y-3">
                        @can('update', $property)
                        <!-- Botões de Administração -->
                        <div class="flex space-x-2 mb-3">
                            <a href="{{ route('properties.edit', $property) }}"
                               class="flex-1 bg-blue-600 text-white py-2 px-3 rounded-lg hover:bg-blue-700 transition duration-200 font-medium text-center text-sm">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Editar
                            </a>
                            <form method="POST" action="{{ route('properties.destroy', $property) }}"
                                  onsubmit="return handleDeleteProperty(event)"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="flex-1 bg-red-600 text-white py-2 px-3 rounded-lg hover:bg-red-700 transition duration-200 font-medium text-sm">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Excluir
                                </button>
                            </form>
                        </div>
                        @endcan

                        <!-- Contatar via WhatsApp -->
                        @if($property->status !== 'vendido' && $property->status !== 'alugado')
                        @php
                            $whatsappNumber = preg_replace('/[^0-9]/', '', $corretorPrincipal->phone ?? '+55629460321');
                            $whatsappMessage = urlencode("Olá {$corretorPrincipal->name}! Tenho interesse no imóvel: {$property->title} - {$property->address}, {$property->city}. Valor: R$ " . number_format($property->numeric_price, 0, ',', '.'));
                            $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$whatsappMessage}";
                        @endphp
                        <a href="{{ $whatsappUrl }}" target="_blank"
                           class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition duration-200 font-medium text-center block flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488"/>
                            </svg>
                            Contatar via WhatsApp
                        </a>
                        @else
                        <div class="w-full bg-gray-100 text-gray-500 py-3 px-4 rounded-lg font-medium text-center block">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            Imóvel Indisponível
                        </div>
                        @endif

                        {{-- Agendar Visita - Desabilitado temporariamente --}}
                        {{-- <a href="{{ route('visits.create', $property) }}"
                           class="w-full bg-secondary-600 text-white py-3 px-4 rounded-lg hover:bg-secondary-700 transition duration-200 font-medium text-center block">
                            Agendar Visita
                        </a> --}}

                        @if($property->status !== 'vendido' && $property->status !== 'alugado')
                        <!-- Favoritar -->
                        <button onclick="toggleFavorite({{ $property->id }})"
                                id="favorite-btn-{{ $property->id }}"
                                class="w-full border-2 border-gray-300 text-gray-700 py-3 px-4 rounded-lg hover:border-primary-600 hover:text-primary-600 transition duration-200 font-medium">
                            <span id="favorite-text-{{ $property->id }}">
                                @auth
                                    @if(auth()->user()->favorites->contains($property->id))
                                        ❤️ Favoritado
                                    @else
                                        Adicionar aos Favoritos
                                    @endif
                                @else
                                    Adicionar aos Favoritos
                                @endauth
                            </span>
                        </button>
                        @endif

                        <!-- Compartilhar -->
                        <button onclick="shareProperty()"
                                class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-200 transition duration-200 font-medium">
                            Compartilhar
                        </button>
                    </div>

                    <!-- Informações adicionais -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Anunciado em:</span>
                                <span>{{ $property->created_at ? $property->created_at->format('d/m/Y') : 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Código:</span>
                                <span>{{ $property->id }}</span>
                            </div>
                            @if($property->published_at)
                            <div class="flex justify-between">
                                <span>Publicado em:</span>
                                <span>{{ $property->published_at->format('d/m/Y') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Imóveis Similares -->
        @if($similarProperties->count() > 0)
        <div class="bg-white rounded-lg shadow-sm p-6 mt-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Imóveis Similares</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($similarProperties as $similarProperty)
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                    <div class="relative">
                        @if($similarProperty->main_image)
                        <img src="{{ $similarProperty->main_image_url }}" alt="{{ $similarProperty->title }}" class="w-full h-48 object-cover">
                        @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif

                        <!-- Badges -->
                        <div class="absolute top-2 left-2 flex flex-col space-y-1">
                            @if($similarProperty->featured)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-accent-500 text-white shadow-lg">
                                Destaque
                            </span>
                            @endif
                            @if($similarProperty->urgent)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500 text-white shadow-lg">
                                Urgente
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-1 line-clamp-2">
                            {{ $similarProperty->title }}
                        </h4>

                        <p class="text-lg font-bold text-primary-600 mb-2">
                            R$ {{ number_format($similarProperty->numeric_price, 0, ',', '.') }}
                            @if($similarProperty->type === 'aluguel')
                            <span class="text-sm font-normal text-gray-500">/mês</span>
                            @endif
                        </p>

                        <p class="text-sm text-gray-600 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $similarProperty->city }} - {{ $similarProperty->state }}
                        </p>

                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <div class="flex items-center space-x-3">
                                @if($similarProperty->bedrooms > 0)
                                <span>{{ $similarProperty->bedrooms }} quarto{{ $similarProperty->bedrooms > 1 ? 's' : '' }}</span>
                                @endif
                                @if($similarProperty->area > 0)
                                <span>{{ $similarProperty->area }}m²</span>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('properties.show', $similarProperty) }}"
                           class="mt-3 w-full bg-primary-600 text-white py-2 px-4 rounded-lg hover:bg-primary-700 transition duration-200 font-medium text-center block text-sm">
                            Ver Detalhes
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

</div>

<script>
const favoriteUrlTemplate = '{{ route("properties.favorite", ["property" => "__PROPERTY_ID__"]) }}';

function propertyGallery(data) {
    return {
        ...data,
        get currentMedia() {
            return this.media[this.currentIndex] || {};
        },
        openLightbox() {
            this.showLightbox = true;
            document.body.style.overflow = 'hidden';
        },
        closeLightbox() {
            this.showLightbox = false;
            this.resetZoom();
            document.body.style.overflow = 'auto';
        },
        nextMedia() {
            this.currentIndex = this.currentIndex < this.media.length - 1 ? this.currentIndex + 1 : 0;
        },
        previousMedia() {
            this.currentIndex = this.currentIndex > 0 ? this.currentIndex - 1 : this.media.length - 1;
        },
        zoomIn() {
            if (this.zoomLevel < 3) {
                this.zoomLevel += 0.25;
            }
        },
        zoomOut() {
            if (this.zoomLevel > 0.5) {
                this.zoomLevel -= 0.25;
            }
        },
        resetZoom() {
            this.zoomLevel = 1;
            this.imagePosition = { x: 0, y: 0 };
        },
        startDrag(event) {
            if (this.zoomLevel <= 1) return;
            this.isDragging = true;
            this.dragStart = {
                x: event.clientX - this.imagePosition.x,
                y: event.clientY - this.imagePosition.y
            };
        },
        drag(event) {
            if (!this.isDragging || this.zoomLevel <= 1) return;
            this.imagePosition = {
                x: event.clientX - this.dragStart.x,
                y: event.clientY - this.dragStart.y
            };
        },
        stopDrag() {
            this.isDragging = false;
        },
        handleZoom(event) {
            event.preventDefault();
            if (event.deltaY < 0) {
                this.zoomIn();
            } else {
                this.zoomOut();
            }
        }
    }
}

function toggleFavorite(propertyId) {
    @auth
        const url = favoriteUrlTemplate.replace('__PROPERTY_ID__', propertyId);
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ property_id: propertyId })
        })
        .then(response => response.json())
        .then(data => {
            const btn = document.getElementById(`favorite-btn-${propertyId}`);
            const text = document.getElementById(`favorite-text-${propertyId}`);

            if (data.favorited) {
                text.textContent = '❤️ Favoritado';
                btn.classList.remove('border-gray-300', 'text-gray-700', 'hover:border-primary-600', 'hover:text-primary-600');
                btn.classList.add('bg-primary-600', 'text-white', 'hover:bg-primary-700');
            } else {
                text.textContent = 'Adicionar aos Favoritos';
                btn.classList.remove('bg-primary-600', 'text-white', 'hover:bg-primary-700');
                btn.classList.add('border-2', 'border-gray-300', 'text-gray-700', 'hover:border-primary-600', 'hover:text-primary-600');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erro ao atualizar favorito. Tente novamente.');
        });
    @else
        window.location.href = '{{ route('login') }}';
    @endauth
}


// Custom Video Player Alpine.js Component
function customVideoPlayer(videoSrc) {
    return {
        videoSrc: videoSrc,
        isPlaying: false,
        isLoading: true,
        currentTime: 0,
        duration: 0,
        volume: 1,
        isMuted: false,
        progress: 0,
        buffered: 0,

        initPlayer() {
            this.$watch('videoSrc', (newSrc) => {
                if (newSrc && this.$refs.video) {
                    this.$refs.video.load();
                }
            });
        },

        onLoadedMetadata() {
            this.duration = this.$refs.video.duration;
            this.isLoading = false;
            console.log('Video loaded, duration:', this.duration);
        },

        onTimeUpdate() {
            this.currentTime = this.$refs.video.currentTime;
            this.progress = (this.currentTime / this.duration) * 100;
        },

        onProgress() {
            if (this.$refs.video.buffered.length > 0) {
                const bufferedEnd = this.$refs.video.buffered.end(this.$refs.video.buffered.length - 1);
                this.buffered = (bufferedEnd / this.duration) * 100;
            }
        },

        onPlay() {
            this.isPlaying = true;
        },

        onPause() {
            this.isPlaying = false;
        },

        onEnded() {
            this.isPlaying = false;
        },

        togglePlay() {
            if (this.$refs.video) {
                if (this.isPlaying) {
                    this.$refs.video.pause();
                } else {
                    this.$refs.video.play();
                }
            }
        },

        seek(event) {
            if (this.$refs.video && this.duration) {
                const rect = event.currentTarget.getBoundingClientRect();
                const clickX = event.clientX - rect.left;
                const percentage = clickX / rect.width;
                const newTime = percentage * this.duration;
                this.$refs.video.currentTime = newTime;
            }
        },

        toggleMute() {
            if (this.$refs.video) {
                this.$refs.video.muted = !this.$refs.video.muted;
                this.isMuted = this.$refs.video.muted;
            }
        },

        setVolume(event) {
            if (this.$refs.video) {
                const rect = event.currentTarget.getBoundingClientRect();
                const clickX = event.clientX - rect.left;
                const percentage = Math.max(0, Math.min(1, clickX / rect.width));
                this.$refs.video.volume = percentage;
                this.volume = percentage;
                this.isMuted = percentage === 0;
            }
        },

        toggleFullscreen() {
            if (this.$refs.video) {
                if (document.fullscreenElement) {
                    document.exitFullscreen();
                } else {
                    this.$refs.video.requestFullscreen();
                }
            }
        },

        formatTime(seconds) {
            if (isNaN(seconds)) return '0:00';
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        }
    };
}

function shareProperty() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $property->title }}',
            text: 'Confira este imóvel incrível!',
            url: window.location.href,
        });
    } else {
        // Fallback para copiar para clipboard
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert('Link copiado para a área de transferência!');
        });
    }
}

</script>

<script>
async function handleDeleteProperty(event) {
    event.preventDefault();

    const confirmed = await showConfirmation(
        'Tem certeza que deseja excluir este imóvel? Esta ação não pode ser desfeita.',
        'Excluir Imóvel'
    );

    if (confirmed) {
        event.target.submit();
    }

    return false;
}
</script>
@endsection
