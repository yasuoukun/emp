<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserPaymentMethod;

class PaymentMethodController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'provider' => 'required|string|max:100',
            'account_name' => 'required|string|max:150',
            'account_number' => 'required|string|max:50',
        ]);

        $userId = auth()->id();
        $isFirst = UserPaymentMethod::where('user_id', $userId)->count() === 0;

        UserPaymentMethod::create([
            'user_id' => $userId,
            'provider' => $validated['provider'],
            'account_name' => $validated['account_name'],
            'account_number' => $validated['account_number'],
            'is_default' => $isFirst,
        ]);

        return redirect()->back()->with('sweet_success', 'เพิ่มบัญชีชำระเงินสำเร็จ');
    }

    public function setDefault(UserPaymentMethod $paymentMethod)
    {
        if ($paymentMethod->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'ไม่ได้รับอนุญาต');
        }

        UserPaymentMethod::where('user_id', auth()->id())->update(['is_default' => false]);
        $paymentMethod->update(['is_default' => true]);

        return redirect()->back()->with('sweet_success', 'ตั้งเป็นบัญชีหลักเรียบร้อย');
    }

    public function destroy(UserPaymentMethod $paymentMethod)
    {
        if ($paymentMethod->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'ไม่ได้รับอนุญาต');
        }

        $wasDefault = $paymentMethod->is_default;
        $paymentMethod->delete();

        // If deleted payment method was default, set another one as default
        if ($wasDefault) {
            $next = UserPaymentMethod::where('user_id', auth()->id())->first();
            if ($next) {
                $next->update(['is_default' => true]);
            }
        }

        return redirect()->back()->with('sweet_success', 'ลบบัญชีชำระเงินสำเร็จ');
    }
}
