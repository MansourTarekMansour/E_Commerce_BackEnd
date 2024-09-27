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
use Illuminate\Support\Facades\Storage;
use App\Traits\HandlesProductsPermissions;

class ProductController extends BaseController
{
    use HandlesProductsPermissions;
    public function __construct()
    {
        $this->middleware('auth');
        $this->setupProductsPermissions();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::query()->with(['category', 'brand', 'comments']); // Eager load relationships

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        // Filter by start date
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        // Filter by end date
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }


        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Order the products in descending order
        $products = $query->orderBy('id', 'desc')->paginate(10);

        // Get all categories and brands
        $categories = Category::get();
        $brands = Brand::get();

        return view('products.index', compact('products', 'categories', 'brands'));
    }




    public function create(): View
    {
        $categories = Category::all(); // Fetch all categories
        $brands = Brand::all(); // Fetch all brands

        return view('products.create', compact('categories', 'brands'));
    }



    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'discount_price' => 'nullable|numeric|min:0|max:99999999.99',
            'quantity_in_stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'images' => 'nullable|array', // New validation for images
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Individual image validation
        ]);

        // Create a new product instance
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'quantity_in_stock' => $request->quantity_in_stock,
            'quantity_sold' => 0, // Assuming initially no items sold
            'is_available' => true, // Default value
            'rating' => 0, // Default rating
            'user_id' => Auth::id(), // Use the authenticated user's ID
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
        ]);

        // Handle file uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Ensure file is not null
                if ($file) {
                    $path = $file->store('product_images', 'public'); // Store image in 'public/product_images' directory

                    // Create a new File record
                    File::create([
                        'url' => $path,
                        'fileable_id' => $product->id,
                        'fileable_type' => Product::class,
                        'file_type' => 'image', // Define your own logic here if necessary
                    ]);
                }
            }
        }
        // Return a success response
        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }



    public function show(Product $product): View
    {
        $category = $product->category;
        $brand = $product->brand;
        $categories = Category::all(); // Assuming you have a Category model
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
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'quantity_in_stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'images' => 'nullable|array', // New validation for images
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Individual image validation
        ]);

        // Update the product with the new data
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'quantity_in_stock' => $request->quantity_in_stock,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
        ]);

        // Delete old images if new images are provided
        if ($request->hasFile('images')) {

            // Handle new file uploads
            foreach ($request->file('images') as $file) {
                if ($file) {
                    $path = $file->store('product_images', 'public'); // Store image in 'public/product_images' directory

                    // Create a new File record for each uploaded image
                    File::create([
                        'url' => $path,
                        'fileable_id' => $product->id,
                        'fileable_type' => Product::class,
                        'file_type' => 'image',
                    ]);
                }
            }
        }

        // Return a success response
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function uploadImage(Request $request, Product $product)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle the upload
        $file = $request->file('image');
        $path = $file->store('product_images', 'public'); // Store in storage/app/public/product_images

        // Create a new file entry in the database (assuming your File model is set up correctly)
        $product->files()->create([
            'url' => $path,
            'file_type' => 'image', // Adjust this according to your implementation
        ]);

        return response()->json(['success' => true, 'file' => $path]);
    }

    public function destroy(Product $product): RedirectResponse
    {
        // Optionally, delete the associated files (images)
        foreach ($product->files as $file) {
            // Delete the file from storage
            if (Storage::exists($file->url)) {
                Storage::delete($file->url); // Delete the file from storage
            }

            // Delete the file record from the database
            $file->delete();
        }

        // Delete the product from the database
        $product->delete();

        // Return a success response
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    public function destroyFile(File $file)
    {
        if (Storage::exists($file->url)) {
            Storage::delete($file->url);
        }
        $file->delete();
        return response()->json(['message' => 'Image deleted successfully.'], 200);
    }
}
