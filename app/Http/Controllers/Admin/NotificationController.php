<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\PromotionNotification;

class NotificationController extends Controller
{
    public function index()
    {
        return view('admin.notifications.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'url' => 'nullable|url',
        ]);

        $users = User::all();
        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('notifications', 'public');
        }

        foreach ($users as $user) {
            $user->notify(new PromotionNotification(
                $request->title,
                $request->message,
                $request->url,
                $imagePath
            ));
        }

        return redirect()->back()->with('success', 'ส่งแจ้งเตือนโปรโมชันถึงลูกค้าทุกคนเรียบร้อยแล้ว');
    }
}
