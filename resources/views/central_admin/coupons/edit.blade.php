<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">แก้ไขคูปองส่วนลด</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('central_admin.coupons.update', $coupon) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">รหัสคูปอง (ตัวพิมพ์ใหญ่ทั้งหมด เช่น DISCOUNT50)</label>
                        <input type="text" name="code" value="{{ old('code', $coupon->code) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required placeholder="เช่น SUMMER100">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">จำนวนส่วนลด (บาท)</label>
                        <input type="number" step="0.01" name="discount_amount" value="{{ old('discount_amount', $coupon->discount_amount) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required min="0" placeholder="เช่น 100.00">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">วันหมดอายุ (Expires At)</label>
                        <input type="date" name="expires_at" value="{{ old('expires_at', $coupon->expires_at) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required min="{{ date('Y-m-d') }}">
                    </div>

                    <div class="flex items-center">
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded font-bold hover:bg-blue-700 shadow transition-all">บันทึกการเปลี่ยนแปลง</button>
                        <a href="{{ route('central_admin.coupons.index') }}" class="px-6 py-2.5 bg-gray-500 text-white rounded font-bold hover:bg-gray-600 ml-3">ยกเลิก</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
