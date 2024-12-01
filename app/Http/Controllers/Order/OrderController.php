<?php

namespace App\Http\Controllers\Order;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    


    // Show the form to create a new order 
    public function create()
    {
        if(Auth::check()){
            $userId = Auth::id(); // This gets the ID of the authenticated user
            $customer_id = session()->get('customerId');
            $cart_id = session()->get('cartId');
    
            $cartItems = CartItem::with('product') // Eager load the product relationship
            ->where('cart_id', $cart_id)
            ->get();
    
    
            // Prepare product details with quantities
            $products = $cartItems->map(function ($cartItem) {
                return [
                    'product' => $cartItem->product, // Access the loaded product
                    'quantity' => $cartItem->quantity,
    
                ];
            });
    
            $totalPrice = $cartItems->sum(function($cartItem) {
                return $cartItem->quantity * $cartItem->product->price; // Assuming you have quantity and price fields
            });
    
            return view('customer.order', compact('products','totalPrice'));
    
        };
    }


    // delete cart when user place order

    public function deleteCart(){

        if(Auth::check()){
            $cart_id = session()->get('cartId');
            CartItem::where('cart_id', $cart_id)->delete();
            return response()->json([], 200);        }
        else{
            return response()->json([], 400);        }
     
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'order_date' => 'required|date',
            'status' => 'nullable|string|max:255',
        ]);

        // Create a new order
        Order::create([
            'customer_id' => Auth::id(),
            'order_date' => $request->order_date,
            'status' => $request->status,
        ]);

        $response = $this->deleteCart();

        // Redirect to the list
        return redirect()->route('welcome')->with('success', 'Order created successfully.');
    }

    // Display all customer order  
    public function index() 
    {
        $orders = Order::where('customer_id', Auth::id())->get(); 
        return view('customer.allOrders', compact('orders')); 
    }

    // // Display the specified order 
    // public function show($id)
    // {
    //     $order = Order::where('customer_id', Auth::id())->findOrFail($id);
    //     return view('user.show', compact('order'));
    // }

    // Remove the specified order 
    public function destroy($id)
    {
        $order = Order::where('customer_id', Auth::id())->findOrFail($id); 
        $order->delete();

        // Redirect back to the user's order 
        return redirect()->route('customer.allOrders')->with('success', 'Order deleted successfully.');
    }

}
