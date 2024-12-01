<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{

    public function getCartItems(){
        if(Auth::check()){
            $userId = Auth::id(); // This gets the ID of the authenticated user
            $customer_id = session()->get('customerId');
            $cart_id = session()->get('cartId');
    
            $cartItems = CartItem::with('product') // Eager load the product relationship
            ->where('cart_id', $cart_id)
            ->get();
    
    
            $totalPrice = $cartItems->sum(function($cartItem) {
                return $cartItem->quantity * $cartItem->product->price; // Assuming you have quantity and price fields
            });
    
            // Prepare product details with quantities
            $products = $cartItems->map(function ($cartItem) {
                return [
                    'product' => $cartItem->product, // Access the loaded product
                    'quantity' => $cartItem->quantity,
    
                ];
            });
    
            return view('customer.cart', compact('products','totalPrice'));
    

        }

    
        else {
            /// sessions
            // For guest users, use session-based cart handling
            $cartItems = session()->get("cart");
    
            // Assuming session contains product IDs, retrieve associated products
            if (!empty($cartItems)) {
                $cartItems = session()->get('cart'); // Retrieve cart items from the session
    
                $productIds = [];
                $quantities = [];
    
                foreach ($cartItems as $productId => $item) {
                    $productIds[] = $productId; // Add the product ID (key of the array)
                    $quantities[$productId] = $item['quantity']; // Add the quantity
                }
    
                // Retrieve products from the database
                $products = Product::whereIn('id', $productIds)->get();
    
                // Combine product details with quantities
                $products = $products->map(function ($product) use ($quantities) {
                    return [
                        'product' => $product,
                        'quantity' => $quantities[$product->id] ?? 0,
                    ];
                });
    
                // Calculate total price
                $totalPrice = 0;
                foreach ($products as $item) {
                    $totalPrice += $item['product']->price * $item['quantity'];
                }
    
                return view('customer.cart', compact('products', 'totalPrice'));
            }
            else {
                $products = collect(); 
                $totalPrice = 0; 
                return view('customer.cart',compact('products','totalPrice'));
            }
    
    
    
        }
    
    }












// test if user is not auth
public function addItemtoCart(Request $request) {
    $product_id = $request->id; // Use the route parameter

    if (Auth::check()) {
        $userId = Auth::id(); // Get the ID of the authenticated user
        $customer_id = session()->get('customerId');
        $cart_id = session()->get('cartId');

        // Check if the item already exists in the cart
        $cartItem = CartItem::where('cart_id', $cart_id)
                            ->where('product_id', $product_id)
                            ->first();

        if ($cartItem) {
            // Item exists, increase the quantity
            $cartItem->quantity += 1;
            $cartItem->save(); // Save the updated cart item
        } else {
            // Item doesn't exist, create a new cart item
            CartItem::create([
                'cart_id' => $cart_id,
                'product_id' => $product_id,
                'quantity' => 1, // Set initial quantity
            ]);
        }
        return redirect()->route('welcome');
    } else {

        // Fetch the current cart session or initialize an empty one
        $cart = session()->get('cart');

        // Check if the product is already in the cart
        if (isset($cart[$product_id])) {
            // Update the quantity for the existing product
            $cart[$product_id]['quantity'] += 1;
        } else {
            // Add a new product with an initial quantity of 1
            $cart[$product_id] = ['quantity' => 1];
        }
        // Update the session with the modified cart (this merges the old data)
        session()->put('cart', $cart);
        $session = session()->all();
        // Return the session for debugging
        // return dd(session()->get('cart'));
        return redirect()->route('welcome');
        // return view('welcome',compact('session'));
    }
}

public function storeProjectInSession($product_id) {
     // Check if 'cart' exists in session, if not create it

        // Guest user: handle cart in session
        $cart = session()->get('cart',[]);

        // Check if the product already exists in the session cart
        $itemKey = array_search($product_id, array_column($cart, 'product_id'));

        if ($itemKey !== false) {
            // If item exists, increment the quantity
            $newQuantity = $cart[$itemKey]['quantity'] + 1;


            $cart[$itemKey]['quantity'] = $newQuantity;
        } else {

            $cart[] = [
                'product_id' => $product_id,
                'quantity' => 1,
            ];
        }

        // Store the updated cart in session
        session()->put('cart', $cart);

}
public function addOrIncrementItemInCart(Request $request){
    // Validate the input to ensure product_id and quantity are provided
    $validatedData = $request->validate([
        'product_id' => 'required|integer',
        'quantity' => 'required|integer|min:1',
    ]);

    $productId = $request->input('product_id');
    $quantityToAdd = $request->input('quantity');

    // Fetch the product to check available stock
    $product = Product::find($productId);

    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }

    // Check if the user is authenticated
    if (Auth::check()) {
        // Authenticated user: fetch the cart item from the database or create a new one
        $cartItem = Cart::where('customer_id', Auth::id())
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            // If the item is already in the cart, increment the quantity
            $newQuantity = $cartItem->quantity + $quantityToAdd;

            // Check if the new quantity exceeds available stock
            if ($newQuantity > $product->available_stock) {
                return response()->json(['error' => 'Not enough stock available'], 400);
            }

            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            // If the item is not in the cart, add a new cart item
            if ($quantityToAdd > $product->available_stock) {
                return response()->json(['error' => 'Not enough stock available'], 400);
            }

            Cart::create([
                'customer_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $quantityToAdd,
            ]);
        }
    } else {
        // Guest user: handle cart in session
        $cart = session()->get('cart', []);

        // Check if the product already exists in the session cart
        $itemKey = array_search($productId, array_column($cart, 'product_id'));

        if ($itemKey !== false) {
            // If item exists, increment the quantity
            $newQuantity = $cart[$itemKey]['quantity'] + $quantityToAdd;

            // Check if the new quantity exceeds available stock
            if ($newQuantity > $product->available_stock) {
                return response()->json(['error' => 'Not enough stock available'], 400);
            }

            $cart[$itemKey]['quantity'] = $newQuantity;
        } else {
            // If item doesn't exist, add a new one
            if ($quantityToAdd > $product->available_stock) {
                return response()->json(['error' => 'Not enough stock available'], 400);
            }

            $cart[] = [
                'product_id' => $productId,
                'quantity' => $quantityToAdd,
            ];
        }

        // Store the updated cart in session
        session()->put('cart', $cart);
    }

    return response()->json(['success' => 'Item added or quantity updated successfully'], 200);
}




// increament item 
public function addItem($product_id) {
    if (Auth::check()) {
        $session = session()->get('cartId');
        $cartItem = CartItem::where('cart_id', $session)->where('product_id', $product_id)->first();
        // return dd($cartItem);
        $quantity = $cartItem->quantity +=1;

        $cartItem->save();

        $cartItems = CartItem::where('cart_id', $session)->with('product')->get();

        // Calculate total price
        $totalPrice = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price; // Assuming you have a price attribute in the product model
        });
        $product = Product::where('id', $product_id)->firstOrFail();
        // return dd($product);

        view('customer.item',compact('totalPrice','quantity','product'));
        return redirect()->route('cart.view');
    }
    else {
        $cart = session()->get('cart');

        // Check if the product is already in the cart

        // Update the quantity for the existing product
        $quantity = $cart[$product_id]['quantity'] += 1;
        // Update the session with the modified cart (this merges the old data)
        session()->put('cart', $cart);


        $product = Product::where('id', $product_id)->firstOrFail();
        view('customer.item',compact('quantity','product'));
        return redirect()->route('cart.view');

    }
}



// decrement item from cart 
public function removeItem($product_id){ 
    
    if (Auth::check()) {
        $session = session()->get('cartId');
        $cartItem = CartItem::where('cart_id', $session)->where('product_id', $product_id)->first();
        // return dd($cartItem);
        if($cartItem->quantity <= 1){
            return $this->deleteItem($product_id);
        }

        $quantity = $cartItem->quantity -=1;

        $cartItem->save();

        $cartItems = CartItem::where('cart_id', $session)->with('product')->get();

        // Calculate total price
        $totalPrice = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price; // Assuming you have a price attribute in the product model
        });
        $product = Product::where('id', $product_id)->firstOrFail();
        // return dd($product);

        view('customer.item',compact('totalPrice','quantity','product'));
        return redirect()->route('cart.view');
    }else {
        $cart = session()->get('cart');

        // Check if the product is already in the cart
        if($cart[$product_id]['quantity'] <= 1){
            return $this->deleteItem($product_id);
        }
        // Update the quantity for the existing product
        $quantity = $cart[$product_id]['quantity'] -= 1;
        // Update the session with the modified cart (this merges the old data)
        session()->put('cart', $cart);


        $product = Product::where('id', $product_id)->firstOrFail();
        view('customer.item',compact('quantity','product'));
        return redirect()->route('cart.view');

    }
}



// delete item from cart ;D 
public function deleteItem($productId)
{
    if (Auth::check()) {
        $cartId = session()->get('cartId');
        CartItem::where('cart_id', $cartId)->where('product_id', $productId)->delete();
    } else {

        $cartItems = session()->get('cart');
        if (!empty($cartItems)) {

            unset($cartItems[$productId]);
            session()->put('cart', $cartItems);
        }
    }

    return redirect()->route('cart.view');
}
}
