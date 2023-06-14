<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::all();

        return response()->json($categories);
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->all());

        return response()->json($category, 201);
    }
}
