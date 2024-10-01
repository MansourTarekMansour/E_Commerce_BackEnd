<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Traits\HandlesProductsPermissions;

class ProductController extends BaseController
{
    use HandlesProductsPermissions;

    public function __construct()
    {
        $this->middleware('auth');
        $this->setupProductsPermissions();
    }

    public function index(Request $request)
    {
        $query = Product::query()->with(['category', 'brand', 'comments']);

        // Apply filters
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Pagination
        $perPage = $request->input('per_page', 10);
        $products = $query->orderBy('id', 'desc')->paginate($perPage);
        $categories = Category::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();

        return view('products.index', compact('products', 'categories', 'brands', 'perPage'))
            ->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    public function create(): View
    {
        $categories = Category::all();
        $brands = Brand::all();

        return view('products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'discount_price' => 'nullable|numeric|min:0|max:99999999.99',
            'quantity_in_stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create a new product
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'quantity_in_stock' => $request->quantity_in_stock,
            'quantity_sold' => 0,
            'is_available' => true,
            'rating' => 0,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
        ]);

        // Store images
        if ($request->hasFile('images')) {
            $product->storeImages($request->file('images'));
        }

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function show(Product $product): View
    {
        $product->load('user');
        $category = $product->category;
        $brand = $product->brand;
        $categories = Category::all();
        $brands = Brand::all();
        
        return view('products.show', compact('product', 'categories', 'brands', 'category', 'brand'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::all();
        $brands = Brand::all();
        
        return view('products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'quantity_in_stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update the product
        $product->update($request->only([
            'name', 'description', 'price', 'discount_price', 'quantity_in_stock', 'category_id', 'brand_id'
        ]));

        // Store new images
        if ($request->hasFile('images')) {
            $product->storeImages($request->file('images'));
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product): RedirectResponse
    {
        // Delete associated files
        foreach ($product->files as $file) {
            $product->deleteImage($file->url);
            $file->delete();
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    public function destroyFile(File $file)
    {
        Product::deleteImage($file->url); 
        $file->delete();
        return response()->json(['message' => 'Image deleted successfully.'], 200);
    }
}