<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class CategoryApiController extends Controller
{
    // Get all categories
    public function index(Request $request)
    {
        try {
            // Load categories with files and products
            $categories = Category::with(['file', 'products.files'])->get();

            return response()->json([
                'status' => true,
                'message' => __('category.categories_retrieved_successfully'), // Use translation
                'data' => CategoryResource::collection($categories)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('category.categories_retrieval_failed', ['error' => $e->getMessage()]), // Use translation
                'data' => null
            ], 500);
        }
    }

    // Get products for a specific category
    public function show($id, Request $request)
    {
        try {
            // Find the category by ID with related products and images
            $category = Category::with(['file', 'products.files'])->findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => __('category.categories_retrieved_successfully'), // Use translation
                'data' => new CategoryResource($category) // Return a single category resource
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => __('category.categories_retrieval_failed', ['error' => __('Category not found.')]), // Use translation
                'data' => null
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('category.categories_retrieval_failed', ['error' => $e->getMessage()]), // Use translation
                'data' => null
            ], 500);
        }
    }
}
