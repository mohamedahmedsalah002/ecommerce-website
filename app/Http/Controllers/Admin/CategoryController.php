<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function create()
    {
        return view('admin.categories');
    }

    public function store(Request $request)
{
    // Validate the category name and provide a custom error message for uniqueness
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
    ], [
        'name.unique' => 'This category already exists ']
    );
    // If validation passes, create the category
    Category::create([
        'name' => $request->name,
    ]);
    
        // Redirect back with success message
        return redirect()->route('admin.product.index')->with('success', 'Category created successfully!');
    }
    
}
