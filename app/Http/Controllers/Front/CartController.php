<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\CartItem;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = CartItem::where('user_id', session('userId'))
            ->where('product_id', $request->product_id)
            ->first();

        if ($item) {
            $item->increment('quantity', $request->quantity);
        } else {
            CartItem::create([
                'user_id' => session('userId'),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        // This is to set class to show class
        session()->flash('show_cart','show_cart');

        $cartProducts = CartItem::with('product')->where('user_id',session('userId'))->get();

        // return view('electrical.partials.cart-products', [
        //     'cartProducts' => $cartProducts,
        // ]);

        return response()->json([
            'html' => view('electrical.partials.cart-products', [
                'cartProducts' => $cartProducts,
            ])->render(),
            'message' => 'Item added successfully',
        ], 200);

        // return response()->json([
        //         'success' => true,
        //         'message' => 'Product Added To Cart',
        //     ]);
        // return back()->with('success', 'Added to cart.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
        ]);

        // CartItem::destroy($request->cart_item_id);
        CartItem::where('id', $request->cart_item_id)
            ->where('user_id', session('userId')) // or auth()->id()
            ->delete();

        return response()->json([
                'success' => true,
                'message' => 'Product Removed From Cart',
            ]);
    }

    public function index()
    {
        return view('electrical.cart');
    }

    public function update(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:cart_items,id',
            'items.*.quantity' => 'required|numeric',
        ]);

        $removeItems = [];

        foreach ($request['items'] as $item) {
            if($item['quantity'] != 0){
                CartItem::where('id', $item['id'])
                    ->where('user_id', session('userId')) // or auth()->id()
                    ->update(['quantity'=>$item['quantity']]);
            }else{
                CartItem::where('id', $item['id'])
                    ->where('user_id', session('userId')) // or auth()->id()
                    ->delete();
            }
        }

        session()->flash('success','Cart Updated Successfully');

        return response()->json([
                'success' => true,
                'message' => 'Cart Updated Successfully',
            ]);
    }

    public function clear()
    {
        CartItem::where('user_id', session('userId'))->delete();

        session()->flash('success','Cart Cleared.');

        // return response()->json([
        //         'success' => true,
        //         'message' => 'Cart Cleared',
        //     ]);

        return redirect()->route('shop');
    }
}
