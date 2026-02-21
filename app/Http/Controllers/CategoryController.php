<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cat_name' => 'required|string|max:255',
            'description' => 'required|string',
        ], [
            'cat_name.required' => 'Category name is required.',
            'cat_name.string' => 'Category name must be text.',
            'cat_name.max' => 'Category name must not exceed 255 characters.',
            'description.required' => 'Description is required.',
            'description.string' => 'Description must be text.',
        ]);

        Category::create($validatedData);
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'cat_name' => 'required|string|max:255',
            'description' => 'required|string',
        ], [
            'cat_name.required' => 'Category name is required.',
            'cat_name.string' => 'Category name must be text.',
            'cat_name.max' => 'Category name must not exceed 255 characters.',
            'description.required' => 'Description is required.',
            'description.string' => 'Description must be text.',
        ]);

        $category = Category::findOrFail($id);
        $category->update($validatedData);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
