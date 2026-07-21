<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,mov|max:10240',
        ]);

        $mediaPaths = [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $mediaPaths[] = $file->store('reviews', 'public');
            }
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'media_paths' => $mediaPaths,
        ]);

        return redirect()->back()->with('sweet_success', 'ส่งรีวิวพร้อมรูปภาพ/วิดีโอเรียบร้อยแล้ว ขอบคุณสำหรับคำแนะนำครับ!');
    }
}
