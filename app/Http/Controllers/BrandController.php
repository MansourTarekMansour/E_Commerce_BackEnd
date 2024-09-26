<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    // Display a listing of the brands
    public function index()
    {
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
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
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|unique:brands,name,' . $brand->id . '|max:255',
        ]);

        $brand->update([
            'name' => $request->name,
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    // Remove the specified brand from the database
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
    }
}
