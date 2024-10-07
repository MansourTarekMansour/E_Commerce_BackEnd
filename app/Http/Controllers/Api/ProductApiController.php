<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductSimpleResource;
class ProductApiController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Product::with(['category', 'brand', 'files']); // Eager load relations

            // Apply pagination
            $perPage = $request->input('per_page', 10);
            $products = $query->orderBy('id', 'desc')->paginate($perPage);

            return response()->json([
                'status' => 'success',
                'message' => __('product.products_retrieved_successfully'),
                'data' => ProductSimpleResource::collection($products),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('product.products_retrieval_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::with(['category', 'brand', 'files', 'comments'])->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => __('product.product_retrieved_successfully'),
                'data' => new ProductResource($product),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => __('products.product_not_found'),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('product.product_retrieval_failed', ['error' => $e->getMessage()]),
            ], 500);
        }
    }

}
