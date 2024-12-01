<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //
    function welcome(){
        // return  dd(session()->all());
        // session(['cart' => []]);
        $session = session()->all();

        $products = Product::get();
        return view('welcome',compact('products','session'));
    }
}
