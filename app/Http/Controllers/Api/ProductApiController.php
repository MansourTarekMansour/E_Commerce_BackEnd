<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

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
                'status' => true,
                'message' => __('product.products_retrieved_successfully'),
                'data' => ProductResource::collection($products),
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
            $product = Product::with(['category', 'brand', 'files'])->findOrFail($id);

            return response()->json([
                'status' => true,
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

    // public function store(ProductRequest $request)
    // {
    //     try {
    //         $product = Product::create(array_merge($request->validated(), ['user_id' => Auth::id()]));

    //         // Store images if any
    //         if ($request->hasFile('images')) {
    //             $product->storeImages($request->file('images'));
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => __('products.product_added_successfully'),
    //             'data' => new ProductResource($product),
    //         ], 201);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => __('product.product_addition_failed', ['error' => $e->getMessage()]),
    //         ], 500);
    //     }
    // }

    // public function update(ProductRequest $request, $id)
    // {
    //     try {
    //         $product = Product::findOrFail($id);
    //         $product->update($request->validated());

    //         // Store new images if any
    //         if ($request->hasFile('images')) {
    //             $product->storeImages($request->file('images'));
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => __('products.product_updated_successfully'),
    //             'data' => new ProductResource($product),
    //         ], 200);
    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => __('product.product_not_found'),
    //         ], 404);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => __('product.product_update_failed', ['error' => $e->getMessage()]),
    //         ], 500);
    //     }
    // }

    // public function destroy($id)
    // {
    //     try {
    //         $product = Product::findOrFail($id);

    //         // Delete associated files
    //         foreach ($product->files as $file) {
    //             $product->deleteImage($file->url);
    //             $file->delete();
    //         }

    //         $product->delete();

    //         return response()->json([
    //             'status' => true,
    //             'message' => __('products.product_deleted_successfully'),
    //         ], 200);
    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => __('product.product_not_found'),
    //         ], 404);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => __('product.product_deletion_failed', ['error' => $e->getMessage()]),
    //         ], 500);
    //     }
    // }
}
