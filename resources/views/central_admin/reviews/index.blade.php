<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('จัดการรีวิวสินค้าจากลูกค้า') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            <!-- Product Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <form action="{{ route('central_admin.reviews.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                    <div style="flex: 1 1 300px;">
                        <label for="product_filter" class="block text-sm font-semibold text-gray-700 mb-2">🔍 เลือกดูรีวิวตามรุ่นสินค้า (Filter by Model)</label>
                        <select name="product_id" id="product_filter" onchange="this.form.submit()" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 font-medium text-gray-800">
                            <option value="">-- แสดงรีวิวของทุกรุ่น (Show All Models) --</option>
                            @foreach($products as $prod)
                                <option value="{{ $prod->id }}" {{ request('product_id') == $prod->id ? 'selected' : '' }}>
                                    📱 {{ $prod->name }} (มี {{ $prod->reviews->count() }} รีวิว)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if(request('product_id'))
                        <div>
                            <a href="{{ route('central_admin.reviews.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded font-semibold transition inline-block">
                                ล้างตัวกรอง (Clear)
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="border-b p-3 text-left">สินค้า</th>
                            <th class="border-b p-3 text-left">ลูกค้า</th>
                            <th class="border-b p-3 text-center">คะแนน</th>
                            <th class="border-b p-3 text-left">ความคิดเห็น</th>
                            <th class="border-b p-3 text-center">วันที่สร้าง</th>
                            <th class="border-b p-3 text-center">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 align-top">
                                <a href="{{ route('products.show', $review->product_id) }}" target="_blank" class="text-blue-600 hover:underline font-medium">
                                    {{ $review->product->name ?? 'สินค้าถูกลบ' }}
                                </a>
                            </td>
                            <td class="p-3 align-top">
                                <span class="font-medium text-gray-800">{{ $review->user->name ?? 'ลูกค้าทั่วไป' }}</span>
                                <span class="block text-xs text-gray-400">{{ $review->user->email ?? '' }}</span>
                            </td>
                            <td class="p-3 align-top text-center text-yellow-500 font-bold text-lg">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $review->rating ? '★' : '☆' }}
                                @endfor
                            </td>
                            <td class="p-3 align-top text-gray-600 max-w-xs break-words">
                                {{ $review->comment }}
                            </td>
                            <td class="p-3 align-top text-center text-sm text-gray-500">
                                {{ $review->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-3 align-top text-center">
                                <form action="{{ route('central_admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('ยืนยันที่จะลบรีวิวนี้หรือไม่?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1.5 rounded transition">
                                        ลบรีวิว
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500 italic">
                                ยังไม่มีรีวิวสินค้าจากลูกค้าในขณะนี้
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</x-app-layout>
