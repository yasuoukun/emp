<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'desc')->get();
        return view('central_admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('central_admin.coupons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code|max:50',
            'discount_amount' => 'required|numeric|min:0',
            'expires_at' => 'required|date|after_or_equal:today',
        ]);

        Coupon::create($validated);

        return redirect()->route('central_admin.coupons.index')->with('success', 'สร้างคูปองส่วนลดสำเร็จแล้ว');
    }

    public function edit(Coupon $coupon)
    {
        return view('central_admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'discount_amount' => 'required|numeric|min:0',
            'expires_at' => 'required|date|after_or_equal:today',
        ]);

        $coupon->update($validated);

        return redirect()->route('central_admin.coupons.index')->with('success', 'อัปเดตคูปองส่วนลดสำเร็จแล้ว');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('central_admin.coupons.index')->with('success', 'ลบคูปองส่วนลดเรียบร้อยแล้ว');
    }
}
