<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        session(['last_viewed_orders_at' => now()]);
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,pending_verification,confirmed,shipped,delivered,cancelled',
            'tracking_number' => 'nullable|string|max:100',
            'shipping_courier' => 'nullable|string|max:100',
        ]);

        $oldStatus = $order->status;

        if ($validated['status'] === 'confirmed' && $oldStatus !== 'confirmed') {
            $order->update([
                'tracking_number' => $validated['tracking_number'],
                'shipping_courier' => $validated['shipping_courier'],
            ]);
            $order->confirm();
        } else {
            $order->update([
                'status' => $validated['status'],
                'tracking_number' => $validated['tracking_number'],
                'shipping_courier' => $validated['shipping_courier'],
            ]);
        }

        return redirect()->back()->with('success', 'อัปเดตสถานะคำสั่งซื้อเรียบร้อยแล้ว');
    }
}
