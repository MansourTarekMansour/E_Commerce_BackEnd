<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    // Display a listing of the brands
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $brands = Brand::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        })->orderBy('name')->paginate($perPage);

        return view('brands.index', compact('brands', 'search', 'perPage'))
        ->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    // Show the form for creating a new brand
    public function create()
    {
        return view('brands.create');
    }

    // Store a newly created brand in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands|max:255',
        ]);

        Brand::create([
            'name' => $request->name,
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }

    public function storeAjax(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $brand = Brand::create([
            'name' => $request->input('name'),
        ]);

        return response()->json(['id' => $brand->id, 'name' => $brand->name]);
    }


    // Display the specified brand
    public function show(Brand $brand)
    {
        return view('brands.show', compact('brand'));
    }

    // Show the form for editing the specified brand
    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    // Update the specified brand in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Find the brand by ID
        $brand = Brand::findOrFail($id);

        // Update the brand name
        $brand->name = $request->input('name');

        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // Delete the old file if it exists
            if ($brand->file) {
                Storage::disk('public')->delete($brand->file->url);
                // Remove the old file record from the database
                $brand->file()->delete();
            }

            // Store the new file
            $path = $request->file('image')->store('brand_images', 'public');
            $brand->file()->create(['url' => $path]);
        }

        // Save the brand
        $brand->save();

        return redirect()->route('brands.index')
            ->with('success', 'Brand updated successfully.');
    }


    // Remove the specified brand from the database
    public function destroy($id)
    {
        // Find the brand by ID
        $brand = Brand::with('file')->findOrFail($id);

        // Delete the associated file if it exists
        if ($brand->file) {
            Storage::disk('public')->delete($brand->file->url);
            // Remove the file record from the database
            $brand->file()->delete();
        }

        // Delete the brand
        $brand->delete();

        return redirect()->route('brands.index')
            ->with('success', 'Brand deleted successfully.');
    }
}
