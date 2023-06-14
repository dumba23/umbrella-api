<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\ProductFilteringService as FilteringService;

class ProductController extends Controller
{
    public function index(Request $request, FilteringService $filteringService): JsonResponse
    {
        $perPage = 10;

        $query = Product::query();

        $filters = $request->only(['category', 'name', 'description', 'price']);
        $filteringService->applyFilters($query, $filters);

        $products = $query->with('categories')->paginate($perPage);
        $products->load('images');

        return response()->json($products);
    }

    public function show(Product $product): JsonResponse
    {
        $product->load('categories');
        $product->load('images');

        return response()->json($product);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $productData = $request->validated();

        $product = Product::create([
            'name' => $productData['name'],
            'description' => $productData['description'],
            'price' => $productData['price'],
        ]);

        $images = $request->file('image');

        foreach ($images as $image) {
            $path = $image->store('images');

            $product->images()->create([
                'image_path' => $path,
            ]);
        }

        $categories = Category::whereIn('name', $productData['categories'])->pluck('id');
        $product->categories()->attach($categories);

        return response()->json($product, 201);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
