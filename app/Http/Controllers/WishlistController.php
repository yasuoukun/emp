<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    public function toggle($productId)
    {
        if (!auth()->check()) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบก่อนเพิ่มสินค้าที่ชอบ'], 401);
            }
            return redirect()->route('login')->with('error', 'กรุณาเข้าสู่ระบบก่อนเพิ่มสินค้าที่ชอบ');
        }

        $product = Product::find($productId);
        if (!$product) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'ไม่พบสินค้านี้ในระบบ'], 404);
            }
            return redirect()->back()->with('error', 'ไม่พบสินค้านี้ในระบบ');
        }

        $userId = auth()->id();
        $exists = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($exists) {
            $exists->delete();
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'added' => false, 'message' => 'ลบจากสินค้าที่ชอบแล้ว']);
            }
            return redirect()->back();
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'added' => true, 'message' => 'เพิ่มลงในสินค้าที่ชอบแล้ว']);
            }
            return redirect()->back();
        }
    }
}
