<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
class ItemController extends Controller
{

    public function index()
    {
        $items = Item::orderBy('name', 'asc')->get();
        return view('admin.item.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::orderBy('cat_name', 'asc')->get();
        return view('admin.item.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'required|boolean',
        ],[
            'name.required' => 'Item name is required.',
            'price.required' => 'Price is required.',
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category does not exist.',
            'img.image' => 'Uploaded file must be an image.',
            'img.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif.',
            'img.max' => 'Image size must not exceed 2MB.', 
        ]);

        if($request->hasFile('img')){
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalExtension();
            $image->move(public_path('img_item_upload/'), $imageName);
            $validatedData['img'] = $imageName;
        } else {
            $validatedData['img'] = null;
        }

        $item = Item::create($validatedData);

        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $categories = Category::orderBy('cat_name', 'asc')->get();
        $item = Item::findOrFail($id);
        return view('admin.item.edit', compact('item', 'categories'));  
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'img' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'required|boolean',
        ],[
            'name.required' => 'Item name is required.',
            'price.required' => 'Price is required.',
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category does not exist.',
            'img.image' => 'Uploaded file must be an image.',
            'img.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif.',
            'img.max' => 'Image size must not exceed 2MB.', 
        ]);
        if($request->hasFile('img')){
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalExtension();
            $image->move(public_path('img_item_upload/'), $imageName);
            $validatedData['img'] = $imageName;
        }
        $item = Item::findOrFail($id);
        $item->update($validatedData);
        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }
}
