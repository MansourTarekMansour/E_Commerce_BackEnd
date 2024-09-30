<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category; // Assuming you have a Category model

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index(Request $request)
    {
        $query = Category::query();
        $perPage = $request->input('per_page', 10);
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%");
        }
    
        $categories = $query->orderBy('name')->paginate($perPage);
    
        return view('categories.index', compact('categories','perPage'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
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
     */ public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Store the category
        $category = Category::create($request->only('name'));


        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('category_images', 'public');
            File::create([
                'url' => $path,
                'fileable_id' => $category->id,
                'fileable_type' => Category::class,
                'file_type' => 'image',
            ]);
        }

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
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

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update the category name
        $category->update($request->only('name'));

        if ($request->hasFile('image')) {
            if ($category->file) {
                Storage::disk('public')->delete($category->file->url);
                $category->file()->delete();
            }
            $path = $request->file('image')->store('category_images', 'public');
            File::create([
                'url' => $path,
                'fileable_id' => $category->id,
                'fileable_type' => Category::class,
                'file_type' => 'image',
            ]);
        }
        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }


    /**
     * Remove the specified category from the database.
     */
    public function destroy(Category $category)
    {
        if ($category->file) {
            Storage::disk('public')->delete($category->file->url);
            $category->file()->delete();
        }
        $category->delete();
        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
