<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'address_line' => 'required|string|max:500',
            'province' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'subdistrict' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
        ]);

        $isMain = Address::where('user_id', auth()->id())->count() === 0;

        Address::create(array_merge($validated, [
            'user_id' => auth()->id(),
            'is_main' => $isMain,
        ]));

        return redirect()->back()->with('sweet_success', 'เพิ่มที่อยู่สำเร็จแล้ว');
    }

    public function setMain(Address $address)
    {
        if ($address->user_id === auth()->id()) {
            Address::where('user_id', auth()->id())->update(['is_main' => false]);
            $address->update(['is_main' => true]);
            return redirect()->back()->with('sweet_success', 'ตั้งเป็นที่อยู่หลักเรียบร้อยแล้ว');
        }
        return redirect()->back()->with('error', 'ไม่ได้รับอนุญาต');
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'ไม่ได้รับอนุญาต');
        }

        $validated = $request->validate([
            'address_line' => 'required|string|max:500',
            'province' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'subdistrict' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
        ]);

        $address->update($validated);

        return redirect()->back()->with('sweet_success', 'แก้ไขที่อยู่สำเร็จแล้ว');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id === auth()->id()) {
            $wasMain = $address->is_main;
            $address->delete();

            if ($wasMain) {
                $next = Address::where('user_id', auth()->id())->first();
                if ($next) {
                    $next->update(['is_main' => true]);
                }
            }

            return redirect()->back()->with('sweet_success', 'ลบที่อยู่สำเร็จแล้ว');
        }
        return redirect()->back()->with('error', 'ไม่สามารถลบที่อยู่นี้ได้');
    }
}
