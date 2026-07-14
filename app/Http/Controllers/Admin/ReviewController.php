<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'product']);
        
        if ($request->has('product_id') && $request->product_id != '') {
            $query->where('product_id', $request->product_id);
        }
        
        $reviews = $query->orderBy('created_at', 'desc')->get();
        $products = \App\Models\Product::has('reviews')->get();
        
        return view('central_admin.reviews.index', compact('reviews', 'products'));
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->back()->with('success', 'ลบรีวิวเรียบร้อยแล้ว');
    }
}
