<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //

    public function index() {
        $products=Product::get();
        return view('welcome',compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id); 
        return view('customer.productDetails', compact('product'));
    }

}
