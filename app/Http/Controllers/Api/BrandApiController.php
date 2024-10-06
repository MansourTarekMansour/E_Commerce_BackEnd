<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Http\Resources\ProductResource;

class BrandApiController extends Controller
{
    // Get all brands
    public function index(Request $request)
    {
        try {
            $brands = Brand::with(['file', 'products.files'])->get(); // Load files for brands and products

            return response()->json([
                'status' => true,
                'message' => __('brand.brands_retrieved_successfully'),
                'data' => BrandResource::collection($brands)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('brand.brands_retrieval_failed', ['error' => $e->getMessage()]),
                'data' => null
            ], 500);
        }
    }

    // Get products for a specific brand
    public function show($id, Request $request)
    {
        try {
            // Find the brand by ID with related products and images
            $brand = Brand::with(['file', 'products.files'])->findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => __('brand.brands_retrieved_successfully'), // Use translation
                'data' => new BrandResource($brand) // Return a single brand resource
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => __('brand.brands_retrieval_failed', ['error' => __('Brand not found.')]), // Use translation
                'data' => null
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('brand.brands_retrieval_failed', ['error' => $e->getMessage()]), // Use translation
                'data' => null
            ], 500);
        }
    }
}
