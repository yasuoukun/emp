<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">จัดการคูปองส่วนลด</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('central_admin.coupons.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold shadow transition-all">สร้างคูปองส่วนลดใหม่</a>
                <table class="w-full mt-6 border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                            <th class="border p-3 text-left">รหัสคูปอง (Code)</th>
                            <th class="border p-3 text-center">ส่วนลด (Discount Amount)</th>
                            <th class="border p-3 text-center">วันหมดอายุ (Expires At)</th>
                            <th class="border p-3 text-center">จัดการ (Actions)</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @forelse($coupons as $coupon)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="border p-3 text-left font-bold text-gray-800">{{ $coupon->code }}</td>
                            <td class="border p-3 text-center text-red-500 font-semibold">฿{{ number_format($coupon->discount_amount, 2) }}</td>
                            <td class="border p-3 text-center">{{ \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') }}</td>
                            <td class="border p-3 text-center">
                                <a href="{{ route('central_admin.coupons.edit', $coupon) }}" class="text-blue-500 hover:underline mr-3">แก้ไข</a>
                                <form action="{{ route('central_admin.coupons.destroy', $coupon) }}" method="POST" class="inline" onsubmit="return confirm('ยืนยันการลบคูปองส่วนลดนี้?')">
                                    @csrf @method("DELETE")
                                    <button type="submit" class="text-red-500 hover:underline">ลบ</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="border p-6 text-center text-gray-400">ยังไม่มีข้อมูลคูปองส่วนลดในระบบ</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
