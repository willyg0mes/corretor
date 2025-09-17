<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyVideo;
use App\Models\User;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    /**
     * Display a listing of properties with advanced filtering
     */
    public function index(Request $request)
    {
        $query = Property::with(['category', 'user', 'images'])
            ->published()
            ->active();

        // Apply filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('city')) {
            $query->byCity($request->city);
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->byPriceRange($request->min_price, $request->max_price);
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }

        if ($request->boolean('featured')) {
            $query->featured();
        }

        if ($request->boolean('urgent')) {
            $query->urgent();
        }

        // Features filters
        if ($request->filled('features')) {
            $features = $request->features;
            foreach ($features as $feature) {
                $query->whereJsonContains('features', $feature);
            }
        }

        // Amenities filters
        if ($request->filled('amenities')) {
            $amenities = $request->amenities;
            foreach ($amenities as $amenity) {
                $query->whereJsonContains('amenities', $amenity);
            }
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('address', 'like', "%{$searchTerm}%")
                  ->orWhere('neighborhood', 'like', "%{$searchTerm}%")
                  ->orWhere('city', 'like', "%{$searchTerm}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        switch ($sortBy) {
            case 'price':
                $query->orderBy('price', $sortDirection);
                break;
            case 'area':
                $query->orderBy('area', $sortDirection);
                break;
            case 'created_at':
            default:
                $query->orderBy('created_at', $sortDirection);
                break;
        }

        $properties = $query->paginate(12)->withQueryString();

        $categories = Category::active()->ordered()->get();

        // Buscar cidades que têm imóveis cadastrados
        $availableCities = Property::select('city')
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->orderBy('city')
            ->pluck('city')
            ->toArray();

        return view('properties.index', compact('properties', 'categories', 'availableCities'));
    }

    /**
     * Show the form for creating a new property
     */
    public function create()
    {
        // Apenas corretores e admins podem criar imóveis
        if (!auth()->user()->isCorretor() && !auth()->user()->isAdmin()) {
            abort(403, 'Acesso negado. Apenas corretores podem criar imóveis.');
        }

        $categories = Category::active()->ordered()->get();

        return view('properties.create', compact('categories'));
    }

    /**
     * Store a newly created property
     */
    public function store(Request $request)
    {
        // Log para debug
        \Log::info('PropertyController@store - Iniciando criação de imóvel', [
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role ?? 'unknown',
            'request_method' => $request->method(),
            'has_files' => $request->hasFile('images') || $request->hasFile('videos'),
            'images_count' => $request->hasFile('images') ? count($request->file('images')) : 0,
            'videos_count' => $request->hasFile('videos') ? count($request->file('videos')) : 0,
            'content_length' => $request->header('Content-Length'),
        ]);

        // Apenas corretores e admins podem criar imóveis
        if (!auth()->user()->isCorretor() && !auth()->user()->isAdmin()) {
            \Log::warning('PropertyController@store - Acesso negado', [
                'user_id' => auth()->id(),
                'user_role' => auth()->user()->role ?? 'unknown',
            ]);
            abort(403, 'Acesso negado. Apenas corretores podem criar imóveis.');
        }

        try {
                $validated = $request->validate([
                    'title' => 'required|string|max:255',
                    'description' => 'required|string',
                    'category_id' => 'required|exists:categories,id',
                    'type' => 'required|in:venda,aluguel',
                    'price' => 'required|numeric|min:0',
                    'address' => 'required|string|max:255',
                    'neighborhood' => 'required|string|max:255',
                    'city' => 'required|string|max:255',
                    'state' => 'required|string|size:2',
                    'zip_code' => 'nullable|string|max:10',
                    'bedrooms' => 'nullable|integer|min:0',
                    'bathrooms' => 'nullable|integer|min:0',
                    'parking_spaces' => 'nullable|integer|min:0',
                    'area' => 'required|integer|min:1',
                    'land_area' => 'nullable|integer|min:0',
                    'features' => 'nullable|array',
                    'features.*' => 'string',
                    'amenities' => 'nullable|array',
                    'amenities.*' => 'string',
                    'featured' => 'nullable|boolean',
                    'urgent' => 'nullable|boolean',
                    'images' => 'required|array|min:1|max:10',
                    'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:25600', // 25MB por imagem
                    'videos' => 'nullable|array|max:3',
                    'videos.*' => 'mimes:mp4,mov,avi|max:307200', // 300MB por vídeo
                ]);

            \Log::info('PropertyController@store - Validação passou', [
                'validated_fields' => array_keys($validated),
                'features_count' => isset($validated['features']) ? count($validated['features']) : 0,
                'amenities_count' => isset($validated['amenities']) ? count($validated['amenities']) : 0,
                'images_count' => isset($validated['images']) ? count($validated['images']) : 0,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('PropertyController@store - Erro de validação', [
                'validation_errors' => $e->errors(),
                'request_data' => $request->all(),
            ]);
            throw $e;
        }

        DB::transaction(function () use ($validated, $request) {
            \Log::info('PropertyController@store - Criando imóvel no banco');

                // Buscar corretor principal (Jieson Alaor)
                $corretorPrincipal = User::where('role', 'corretor')->where('name', 'Jieson Alaor')->first();
                if (!$corretorPrincipal) {
                    // Criar se não existir
                    $corretorPrincipal = User::create([
                        'name' => 'Jieson Alaor',
                        'email' => 'jieson.corretor@corretor.com',
                        'password' => bcrypt('password'),
                        'role' => 'corretor',
                        'creci' => '42090',
                        'phone' => '+55 62 9464-0321',
                        'bio' => 'Corretor especializado em imóveis residenciais e comerciais. Experiência comprovada no mercado imobiliário.',
                        'email_verified_at' => now(),
                    ]);
                }

                $property = Property::create([
                    'user_id' => $corretorPrincipal->id, // Sempre usar o corretor principal
                    'category_id' => $validated['category_id'],
                    'type' => $validated['type'],
                    'title' => $validated['title'],
                    'description' => $validated['description'],
                    'price' => $validated['price'],
                    'address' => $validated['address'],
                    'neighborhood' => $validated['neighborhood'],
                    'city' => $validated['city'],
                    'state' => $validated['state'],
                    'zip_code' => $validated['zip_code'],
                    'bedrooms' => $validated['bedrooms'],
                    'bathrooms' => $validated['bathrooms'],
                    'parking_spaces' => $validated['parking_spaces'],
                    'area' => $validated['area'],
                    'land_area' => $validated['land_area'],
                    'features' => $validated['features'] ?? [],
                    'amenities' => $validated['amenities'] ?? [],
                    'featured' => $validated['featured'] ?? false,
                    'urgent' => $validated['urgent'] ?? false,
                    'status' => 'ativo',
                    'published_at' => now(),
                ]);

            \Log::info('PropertyController@store - Imóvel criado', [
                'property_id' => $property->id,
                'property_title' => $property->title,
            ]);

            // Handle image uploads
            if ($request->hasFile('images')) {
                \Log::info('PropertyController@store - Processando upload de imagens', [
                    'images_count' => count($request->file('images')),
                ]);
                try {
                    $this->imageUploadService->uploadPropertyImages($property, $request->file('images'));
                    \Log::info('PropertyController@store - Imagens processadas com sucesso');
                } catch (\Exception $e) {
                    \Log::error('PropertyController@store - Erro no upload de imagens', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                    throw $e;
                }
            }

            // Handle video uploads
            if ($request->hasFile('videos')) {
                \Log::info('PropertyController@store - Processando upload de vídeos', [
                    'videos_count' => count($request->file('videos')),
                ]);
                try {
                    $this->imageUploadService->uploadPropertyVideos($property, $request->file('videos'));
                    \Log::info('PropertyController@store - Vídeos processados com sucesso');
                } catch (\Exception $e) {
                    \Log::error('PropertyController@store - Erro no upload de vídeos', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                    throw $e;
                }
            }
        });

        return redirect()->route('properties.index')
            ->with('success', 'Imóvel cadastrado com sucesso!');
    }

    /**
     * Display the specified property
     */
    public function show(Property $property)
    {
        // Increment view count if not the owner
        if (Auth::id() !== $property->user_id) {
            $property->incrementViews();
        }

        $property->load(['category', 'user', 'images', 'videos', 'favorites']);

        // Buscar sempre o corretor principal (Jieson Alaor)
        $corretorPrincipal = User::where('role', 'corretor')->where('name', 'Jieson Alaor')->first();

        $similarProperties = Property::where('category_id', $property->category_id)
            ->where('id', '!=', $property->id)
            ->where('status', 'ativo')
            ->limit(4)
            ->get();

        return view('properties.show', compact('property', 'similarProperties', 'corretorPrincipal'));
    }

    /**
     * Show the form for editing the property
     */
    public function edit(Property $property)
    {
        $this->authorize('update', $property);

        $categories = Category::active()->ordered()->get();

        return view('properties.edit', compact('property', 'categories'));
    }

    /**
     * Update the specified property
     */
    public function update(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:venda,aluguel',
            'price' => 'required|numeric|min:0',
            'currency' => 'string|size:3',
            'address' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'country' => 'string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'parking_spaces' => 'nullable|integer|min:0',
            'area' => 'nullable|integer|min:0',
            'land_area' => 'nullable|integer|min:0',
            'floor' => 'nullable|integer|min:0',
            'total_floors' => 'nullable|integer|min:0',
            'features' => 'nullable|array',
            'amenities' => 'nullable|array',
            'featured' => 'boolean',
            'urgent' => 'boolean',
            'status' => 'required|in:ativo,inativo,vendido,alugado',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
        ]);

        $property->update($validated);

        return redirect()->route('properties.show', $property)
            ->with('success', 'Imóvel atualizado com sucesso!');
    }

    /**
     * Remove the specified property
     */
    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);

        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Imóvel removido com sucesso!');
    }

    /**
     * Toggle favorite status for a property
     */
    public function toggleFavorite(Property $property)
    {
        $user = Auth::user();
        $isFavorited = $property->toggleFavorite($user);

        return response()->json([
            'favorited' => $isFavorited,
            'message' => $isFavorited ? 'Adicionado aos favoritos' : 'Removido dos favoritos'
        ]);
    }

    /**
     * Get user's favorite properties
     */
    public function favorites()
    {
        $user = Auth::user();
        $favorites = $user->favorites()->with('property.images')->paginate(12);

        return view('properties.favorites', compact('favorites'));
    }

    /**
     * Upload images for a property
     */
    public function uploadImages(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $this->imageUploadService->uploadPropertyImages($property, $request->file('images'));

        return response()->json(['message' => 'Imagens enviadas com sucesso']);
    }

    /**
     * Delete a property image
     */
    public function deleteImage(Property $property, PropertyImage $image)
    {
        $this->authorize('update', $property);

        if ($image->property_id !== $property->id) {
            abort(403);
        }

        $image->delete();

        return response()->json(['message' => 'Imagem removida com sucesso']);
    }

    /**
     * Update image order
     */
    public function updateImageOrder(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $request->validate([
            'images' => 'required|array',
            'images.*.id' => 'required|exists:property_images,id',
            'images.*.sort_order' => 'required|integer',
        ]);

        foreach ($request->images as $imageData) {
            PropertyImage::where('id', $imageData['id'])
                ->where('property_id', $property->id)
                ->update(['sort_order' => $imageData['sort_order']]);
        }

        return response()->json(['message' => 'Ordem das imagens atualizada']);
    }
}
