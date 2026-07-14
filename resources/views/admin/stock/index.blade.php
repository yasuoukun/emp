<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-boxes-stacked text-indigo-600"></i>
            จัดการสต๊อกสินค้าอย่างง่าย
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Search & Filters -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
                <form action="{{ route('admin.stock.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
                    <!-- Search Input -->
                    <div class="relative flex-grow w-full md:w-auto">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="ค้นหาชื่อสินค้า..." 
                               class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-medium">
                    </div>

                    <!-- Category Filter -->
                    <select name="category_id" class="w-full md:w-auto px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[160px]">
                        <option value="">📂 ทุกหมวดหมู่</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Brand Filter -->
                    <select name="brand_id" class="w-full md:w-auto px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-semibold bg-white min-w-[160px]">
                        <option value="">🏷️ ทุกแบรนด์</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Submit & Reset Buttons -->
                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" class="flex-grow md:flex-grow-0 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm px-6 py-3 rounded-xl shadow-sm transition">
                            กรองข้อมูล
                        </button>
                        <a href="{{ route('admin.stock.index') }}" class="px-4 py-3 border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-xl text-sm font-bold transition flex items-center justify-center">
                            ล้างค่า
                        </a>
                    </div>
                </form>
            </div>

            <!-- Products Stock Table -->
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100 mb-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-slate-500 text-xs font-semibold uppercase bg-slate-50/80">
                                <th class="py-4 px-5 rounded-tl-xl">สินค้า</th>
                                <th class="py-4 px-5">หมวดหมู่</th>
                                <th class="py-4 px-5">แบรนด์</th>
                                <th class="py-4 px-5 text-right">ราคา</th>
                                <th class="py-4 px-5 text-center">ระดับสต๊อกปัจจุบัน</th>
                                <th class="py-4 px-5 text-center rounded-tr-xl">แก้ไขสต๊อก</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($products as $product)
                            <tr class="hover:bg-indigo-50/30 transition-colors">
                                <!-- Product details & Image -->
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl bg-gray-100 border border-gray-100 p-1 flex items-center justify-center overflow-hidden flex-shrink-0">
                                            @if($product->images->where('is_primary', true)->first())
                                                <img src="{{ str_starts_with($product->images->where('is_primary', true)->first()->image_path, 'http') ? $product->images->where('is_primary', true)->first()->image_path : Storage::url($product->images->where('is_primary', true)->first()->image_path) }}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain">
                                            @else
                                                <span class="text-gray-400 text-[10px]">No Image</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 text-sm line-clamp-1" title="{{ $product->name }}">
                                                {{ $product->name }}
                                            </div>
                                            <div class="text-[11px] text-gray-400">ID: {{ $product->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Category -->
                                <td class="py-4 px-5 text-sm text-slate-600 font-medium">
                                    {{ $product->category->name ?? '-' }}
                                </td>

                                <!-- Brand -->
                                <td class="py-4 px-5 text-sm text-slate-600 font-medium">
                                    {{ $product->brand->name ?? '-' }}
                                </td>

                                <!-- Price -->
                                <td class="py-4 px-5 text-right font-bold text-slate-800 text-sm">
                                    @if($product->discount_price)
                                        <div class="text-xs text-rose-500 line-through">฿{{ number_format($product->price, 2) }}</div>
                                        <div class="text-emerald-600">฿{{ number_format($product->discount_price, 2) }}</div>
                                    @else
                                        <span>฿{{ number_format($product->price, 2) }}</span>
                                    @endif
                                </td>

                                <!-- Stock status -->
                                <td class="py-4 px-5 text-center">
                                    @if($product->stock == 0)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                            🔴 หมดสต๊อก
                                        </span>
                                    @elseif($product->stock < 5)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                            ⚠️ เหลือ {{ $product->stock }} ชิ้น
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                            🟢 พร้อมส่ง {{ $product->stock }} ชิ้น
                                        </span>
                                    @endif
                                </td>

                                <!-- Edit form -->
                                <td class="py-4 px-5 text-center">
                                    <form action="{{ route('admin.stock.update') }}" method="POST" class="flex items-center justify-center gap-1.5 max-w-[150px] mx-auto">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="number" name="stock" value="{{ $product->stock }}" min="0" required
                                               class="w-20 text-center rounded-lg border-gray-300 py-1 text-sm font-semibold focus:ring-indigo-200">
                                        <button type="submit" class="bg-indigo-600 text-white p-1.5 rounded-lg hover:bg-indigo-700 transition" title="บันทึก">
                                            <i class="fa-solid fa-floppy-disk text-xs"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center text-slate-400">
                                    <i class="fa-solid fa-box-open text-4xl mb-3 block"></i>
                                    ไม่พบสินค้าตามที่ค้นหา
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
