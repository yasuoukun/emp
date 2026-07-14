<?php

$dir = __DIR__ . '/resources/views/central_admin/products';
if (!is_dir($dir)) mkdir($dir, 0777, true);

$index = '<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">จัดการสินค้า</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route(\'central_admin.products.create\') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">เพิ่มสินค้าใหม่</a>
                <table class="w-full mt-4 border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">รูปภาพ</th>
                            <th class="border p-2">ชื่อสินค้า</th>
                            <th class="border p-2">หมวดหมู่</th>
                            <th class="border p-2">แบรนด์</th>
                            <th class="border p-2">ราคา</th>
                            <th class="border p-2">สต็อก</th>
                            <th class="border p-2">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="border p-2 text-center">
                                @if($product->images->where(\'is_primary\', true)->first())
                                    <img src="{{ Storage::url($product->images->where(\'is_primary\', true)->first()->image_path) }}" width="50" height="50" style="object-fit: cover;">
                                @else
                                    <div style="width:50px; height:50px; background:#eee; display:inline-block;"></div>
                                @endif
                            </td>
                            <td class="border p-2">{{ $product->name }}</td>
                            <td class="border p-2 text-center">{{ $product->category->name ?? \'-\' }}</td>
                            <td class="border p-2 text-center">{{ $product->brand->name ?? \'-\' }}</td>
                            <td class="border p-2 text-center">฿{{ number_format($product->price, 2) }}</td>
                            <td class="border p-2 text-center">{{ $product->stock }}</td>
                            <td class="border p-2 text-center">
                                <a href="{{ route(\'central_admin.products.edit\', $product) }}" class="text-blue-500 hover:underline">แก้ไข</a> |
                                <form action="{{ route(\'central_admin.products.destroy\', $product) }}" method="POST" class="inline" onsubmit="return confirm(\'ยืนยันการลบ?\')">
                                    @csrf @method("DELETE")
                                    <button type="submit" class="text-red-500 hover:underline">ลบ</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>';
file_put_contents("$dir/index.blade.php", $index);

$form = '<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ isset($product) ? "แก้ไขสินค้า" : "เพิ่มสินค้าใหม่" }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ isset($product) ? route(\'central_admin.products.update\', $product) : route(\'central_admin.products.store\') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($product)) @method("PUT") @endif
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">ชื่อสินค้า</label>
                            <input type="text" name="name" value="{{ old(\'name\', $product->name ?? \'\') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">สต็อก</label>
                            <input type="number" name="stock" value="{{ old(\'stock\', $product->stock ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required min="0">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">ราคาเต็ม</label>
                            <input type="number" step="0.01" name="price" value="{{ old(\'price\', $product->price ?? \'\') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">ราคาโปรโมชัน (เว้นว่างถ้าไม่มี)</label>
                            <input type="number" step="0.01" name="discount_price" value="{{ old(\'discount_price\', $product->discount_price ?? \'\') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">หมวดหมู่</label>
                            <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">-- เลือกหมวดหมู่ --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (old(\'category_id\', $product->category_id ?? \'\') == $cat->id) ? \'selected\' : \'\' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">แบรนด์</label>
                            <select name="brand_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">-- เลือกแบรนด์ --</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ (old(\'brand_id\', $product->brand_id ?? \'\') == $brand->id) ? \'selected\' : \'\' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">รายละเอียดสินค้า</label>
                        <textarea name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old(\'description\', $product->description ?? \'\') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">รูปภาพสินค้า</label>
                        <input type="file" name="image" accept="image/*" class="mt-1 block w-full">
                        @if(isset($product) && $product->images->where(\'is_primary\', true)->first())
                            <div class="mt-2">
                                <img src="{{ Storage::url($product->images->where(\'is_primary\', true)->first()->image_path) }}" width="150">
                                <p class="text-sm text-gray-500">รูปภาพปัจจุบัน (อัปโหลดใหม่เพื่อเปลี่ยน)</p>
                            </div>
                        @endif
                    </div>
                    
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">บันทึก</button>
                    <a href="{{ route(\'central_admin.products.index\') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 ml-2">ยกเลิก</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>';

file_put_contents("$dir/create.blade.php", $form);
file_put_contents("$dir/edit.blade.php", $form);

echo "Product Views Generated.\n";
