<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
use App\Models\Order;

class ClaimController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'device_name' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'claim_type' => 'required|string|in:warranty,repair,setting',
            'issue_description' => 'required|string',
            'order_id_raw' => 'nullable|string|max:100',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $order = null;
        if (!empty($validated['order_id_raw'])) {
            $order = Order::find($validated['order_id_raw']);
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('claims', 'public');
            }
        }

        $claim = Claim::create([
            'user_id' => auth()->id(),
            'order_id' => $order ? $order->id : null,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'device_name' => $validated['device_name'],
            'serial_number' => $validated['serial_number'],
            'claim_type' => $validated['claim_type'],
            'issue_description' => $validated['issue_description'],
            'image_paths' => $imagePaths,
            'status' => 'pending',
        ]);

        return redirect()->route('tracking', ['q' => $claim->id, 'type' => 'claim'])
            ->with('sweet_success', "แจ้งส่งซ่อมของร้านสำเร็จ! หมายเลขงานของท่านคือ: {$claim->id} สามารถใช้ติดตามสถานะได้ทันที");
    }

    public function track(Request $request)
    {
        $q = $request->input('q');
        $type = $request->input('type', 'order'); // order or claim

        $result = null;
        if ($q) {
            if ($type === 'claim') {
                $result = Claim::find($q);
            } else {
                $result = Order::with('items.product')->find($q);
            }
        }

        return view('tracking', compact('result', 'q', 'type'));
    }
}
