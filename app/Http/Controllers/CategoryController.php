<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // Assuming you have a Category model

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = Category::all(); // Fetch all categories
        return view('categories.index', compact('categories')); // Show all categories in the view
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('categories.create'); // Display the category creation form
    }

    /**
     * Store a newly created category in the database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Validate the name
        ]);

        // Create a new category
        $category = new Category();
        $category->name = $validatedData['name'];
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }
    public function storeAjax(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'name' => $request->input('name'),
        ]);

        return response()->json(['id' => $category->id, 'name' => $category->name]);
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category')); // Show the edit form with the category data
    }

    /**
     * Update the specified category in the database.
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Validate the name
        ]);

        // Update the category name
        $category->name = $validatedData['name'];
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category from the database.
     */
    public function destroy(Category $category)
    {
        $category->delete(); // Delete the category
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
