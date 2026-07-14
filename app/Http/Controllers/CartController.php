<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Product::with('images')->findOrFail($id);
        $cart = session()->get('cart', []);
        
        $image = "";
        $primaryImg = $product->images->where('is_primary', true)->first() ?? $product->images->first();
        if ($primaryImg) {
            $image = $primaryImg->image_path;
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->discount_price ?? $product->price,
                "image" => $image
            ];
        }
        
        session()->put('cart', $cart);
        
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'cart_count' => count($cart),
                'message' => 'เพิ่มสินค้าลงตะกร้าเรียบร้อยแล้ว'
            ]);
        }

        return redirect()->route('cart.index')->with('sweet_success', 'เพิ่มสินค้าลงตะกร้าเรียบร้อยแล้ว');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = max(1, intval($request->quantity));
            session()->put('cart', $cart);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    public function view()
    {
        return view('cart.index');
    }
}
