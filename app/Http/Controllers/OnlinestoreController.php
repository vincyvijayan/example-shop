<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Response;
use Auth;
class OnlinestoreController extends Controller
{
    public function index(): View
    {
    	$products = Product::all();
        return view('onlinestore.products', compact('products'));
    }

    public function cart()
    {

        $cart_list = Cart::where('order_status','pending')->with('product')->where('user_id',Auth::user()->id)->get();
        return view('onlinestore.cart', compact('cart_list'));
    }

    public function addToCart(Request $request,$id)
    {      
        $product = Product::find($id);

        $cart = new Cart;
        $cart->product_id = $product->id;
        $cart->price = $product->price;
        $cart->user_id = Auth::id();
        $cart->quantity = 1;
        $cart->save();
 
        return redirect()->route('products')->withSuccess('Added to cart');

    }

    public function update(Request $request)
    {
        if($request->id and $request->quantity)
        {
            $cart = Cart::find($request->id);
            $cart->quantity = $request->quantity;
            $cart->save();
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if($request->id)
        {
            $product = Cart::find($request->id)->delete();
            session()->flash('success', 'Cart removed successfully');
        }
    }
    public function checkout(Request $request)
    {
       
        $total = Cart::where('user_id',Auth::id())->where('order_status','pending')->sum('price');
        return view('onlinestore.checkout',compact('total'));
    }

    public function placeOrder(Request $request)
    {

        $items = Cart::where('user_id',Auth::id())->where('order_status','pending')->get();

        $grand_total = Cart::where('user_id',Auth::id())->where('order_status','pending')->sum('price');
        $item_count = Cart::where('user_id',Auth::id())->where('order_status','pending')->sum('quantity');

        $order = Order::create([
        'order_number'      =>  'ORD-'.strtoupper(uniqid()),
        'user_id'           => auth()->user()->id,
        'status'            =>  'pending',
        'grand_total'       =>  $grand_total,
        'item_count'        =>  $item_count,
        'payment_status'    =>  0,
        'payment_method'    =>  null,
        'first_name'        =>  $request->first_name,
        'last_name'         =>  $request->last_name,
        'address'           =>  $request->address,
        'city'              =>  $request->city,
        'country'           =>  $request->country,
        'post_code'         =>  $request->post_code,
        'phone_number'      =>  $request->phone_number,
        'notes'             =>  $request->notes,
        ]);

        if ($order) {

            foreach ($items as $item)
            {
              
                $product = Product::where('id',$item->product_id)->first();

                $orderItem = new OrderItem([
                    'product_id'    =>  $product->id,
                    'quantity'      =>  $item->quantity,
                    'price'         =>  $item->price
                ]);

                $order->items()->save($orderItem);

                $cart = Cart::find($item->id);
                $cart->order_status = 'complete';
                $cart->save();
            }
        }



        return redirect()->route('products')->withSuccess('Order placed successfully');
    }

    public function apply_voucher($coupon_code){

        $total_sum = Cart::where('user_id',Auth::id())->where('order_status','pending')->sum('price');

        $coupon_total = 50;

        $available_coupon = "VINCY50";

        if($total_sum >= $coupon_total && $available_coupon == $coupon_code){
             
            $cart_details  = Cart::where('user_id',Auth::id())->where('order_status','pending')->get();

            foreach ($cart_details as $key => $value) {
              
                $apply_voucher = Cart::find($value->id);
                $discount = 50;

                $apply_voucher->price = $value->price - $discount;
                $apply_voucher->coupon_code = $coupon_code;
                $apply_voucher->coupon_applied = "yes";
                $apply_voucher->discount = $discount;

                $apply_voucher->save();

                $total = $value->price - $discount;

                return Response::json(['status' =>true,'message' =>'Your coupon discount has been applied!','total' => $total]);
            }
        }

        return Response::json(['status'=>false,'message' =>'Coupon is invalid']); 
    }

}
