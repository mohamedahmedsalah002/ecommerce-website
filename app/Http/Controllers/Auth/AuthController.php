<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use DebugBar\DebugBar;
// use Debugbar; // Correct import for Laravel Debugbar

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
class AuthController extends Controller
{

    public function register() {
        return view("auth.register");
    }

    public function handleRegister(RegisterRequest $request) {
        // pass TestPass@123
        $data = $request->validated();
        $data['password']=Hash::make($request->password);
        $user=User::create($data);
        return redirect()->route('login');
    }
    //
    public function login() {
        return view("auth.login");
    }

    public function handleLogin(LoginRequest $request) {
        $data = $request->validated();
        $isLogin=Auth::attempt(['email'=>$request->email,'password'=>$request->password]);
        if (!$isLogin) {
            return redirect()->route('login')->with('error','not valid email or password');
        }


        if (Auth::user()->role == 'user') {
            // add data customer
            // add first_name and last_name in register view
            // connecting user model with customer model temp

            // if user is an old customer
            $customer = Customer::where('email', Auth::user()->email)->first();

            if(!$customer){
                $customer = Customer::create([
                    'first_name'=>Auth::user()->name,
                    'last_name'=>'default',
                    'email'=>Auth::user()->email
                ]);
                $cart = Cart::create([
                    'customer_id'=>$customer->id
                ]);
            }
//////////////////////////////////////////////////////////////////////

            $cart = Cart::where('customer_id', $customer->id)->first(); // Get the cart for the existing customer
            // return dd($session,$item,$product_id);

            if (session()->has('cart')) {
                $session = session('cart'); // Get the cart session


                foreach ($session as $product_id => $item) {
                    // Create a new cart item entry
                    // Dump the cart session data for debugging

                    // search if customer has same product so increase quantity
                    $cartItem = CartItem::where('cart_id', $cart->id)
                    ->where('product_id', $product_id)
                    ->first();

                    if ($cartItem) {
                        // Item exists, increase the quantity
                        $cartItem->quantity += $item['quantity'];
                        $cartItem->save(); // Save the updated quantity
                    } else {
                        // Item doesn't exist, create a new cart item entry
                        CartItem::create([
                            'cart_id' => $cart->id,
                            'product_id' => $product_id,
                            'quantity' => $item['quantity'],
                        ]);
                    }
                // Optionally, you can clear the cart from the session after storing
            }
            session()->forget('cart');
        }

            ///// if user has empty cart redirct to welcome

            // store cartId in session , store customerID
            session([
                'customerId' => $customer->id,
                'cartId' => $cart->id,
            ]);
            // session()->put('cart', $cart);

            // return  dd(session()->all());
            // echo "cart in session is ".session('cartId'). "customer in session is ".session('customerId');
            return redirect()->route('welcome');





        }
        else{
            return redirect()->route('admin.product.index');
        }

    }

    public function logout() {

        if (Auth::check()) {
            Auth::logout(); // Log the user out
            session()->flush(); // Clear the session
        }

        return redirect()->route('welcome');

    }



}

