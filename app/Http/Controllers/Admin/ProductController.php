<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Department;
use Storage;
class ProductController extends Controller
{


    public function index()
    {
        $products = Product::with('category')->get(); 
        return view('admin.index', compact('products')); 
    }
   /* public function index() {
        $products=Product::get();
        return view('admin.index',compact('products'));
    }*/

    // add -> get form
    public function add() {
        $category = Category::get();
        return view('admin.add',compact('category'));
    }


    //store -> post form
    public function store(ProductRequest $request) {
        // Validate the input
        $data = $request->validated();
    
        // Handle file upload
        if ($request->hasFile('photo')) {
            $photoExt = $request->file('photo')->getClientOriginalExtension();
            $photoName = $request->name . '.' . $photoExt;
            $photoPath = $request->file('photo')->storeAs('images', $photoName);
            $data['photo'] = $photoPath;
        }
    
        // Create the product
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $data['photo'] ?? null // Store path or null
        ]);
    
        return redirect()->back()->with('msg', 'Added..');
    }
    


    public function show($id) {

        $product=Product::where($id)->firstOrFail();
        return view('admin\Products\show',compact('product'));
    }



    
    public function edit($id){
        $category=Category::get();
        $product = Product::findOrFail($id);
        return view('admin.edit',compact('category','product'));
    }
    public function update(ProductRequest $request, $id)
    {
        $data = $request->validated();
        $Product = Product::findOrFail($id);
    
        // Check for name change and handle image renaming
        if ($Product->name !== $data['name'] && $Product->image) {
            $oldImagePath = storage_path('app/public/' . $Product->image);
            $imageExt = pathinfo($Product->image, PATHINFO_EXTENSION);
            $newImageName = $data['name'] . '.' . $imageExt;
            $newImagePath = 'images/' . $newImageName;
    
            if (file_exists($oldImagePath)) {
                rename($oldImagePath, storage_path('app/public/' . $newImagePath));
            }
            $data['image'] = $newImagePath; // Update the image path if the name changed
        }
    
        // Handle the uploaded image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageExt = $image->getClientOriginalExtension();
            $imageName = $data['name'] . '.' . $imageExt;
            $imagePath = $image->storeAs('images', $imageName, 'public');
            
            $data['image'] = $imagePath;
    
            // Delete old image if it exists
            if ($Product->image && file_exists(storage_path('app/public/' . $Product->image))) {
                unlink(storage_path('app/public/' . $Product->image));
            }
        }
    
        // Update the product with all fields including description
        $Product->update($data);
    
        return redirect()->route('admin.product.index')->with('success', 'Product data updated successfully.');
    }

    public function destroy($id)
{
    $product = Product::findOrFail($id);

    // Check if the product has an associated image and delete it from storage
    if ($product->image && Storage::exists($product->image)) {
        Storage::delete($product->image);
    }

    // Delete the product
    $product->delete();

    return redirect()->route('admin.product.index')->with('success', 'Product and image deleted successfully.');
}


}
