<?php

namespace App\Services;

use App\Models\Property;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PropertyService
{
    /**
     * Advanced property search with multiple filters
     */
    public function searchProperties(Request $request): Builder
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

        return $query;
    }

    /**
     * Get featured properties for homepage
     */
    public function getFeaturedProperties(int $limit = 6): \Illuminate\Database\Eloquent\Collection
    {
        return Property::with(['category', 'images'])
            ->featured()
            ->active()
            ->published()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent properties
     */
    public function getRecentProperties(int $limit = 12): \Illuminate\Database\Eloquent\Collection
    {
        return Property::with(['category', 'images'])
            ->active()
            ->published()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get properties by agent
     */
    public function getPropertiesByAgent(int $agentId, int $limit = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = Property::with(['category', 'images'])
            ->where('user_id', $agentId)
            ->active()
            ->published()
            ->latest();

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get similar properties
     */
    public function getSimilarProperties(Property $property, int $limit = 4): \Illuminate\Database\Eloquent\Collection
    {
        return Property::where('category_id', $property->category_id)
            ->where('id', '!=', $property->id)
            ->where('status', Property::STATUS_ATIVO)
            ->published()
            ->with(['category', 'images'])
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /**
     * Get property statistics
     */
    public function getPropertyStats(): array
    {
        return [
            'total' => Property::count(),
            'active' => Property::active()->count(),
            'for_sale' => Property::forSale()->active()->count(),
            'for_rent' => Property::forRent()->active()->count(),
            'featured' => Property::featured()->active()->count(),
            'urgent' => Property::urgent()->active()->count(),
            'avg_price_sale' => Property::forSale()->active()->avg('price') ?? 0,
            'avg_price_rent' => Property::forRent()->active()->avg('price') ?? 0,
        ];
    }
}
