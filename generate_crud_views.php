<?php

$resources = [
    'categories' => ['name_th' => 'หมวดหมู่', 'path' => 'central_admin/categories', 'route' => 'central_admin.categories'],
    'brands' => ['name_th' => 'แบรนด์', 'path' => 'central_admin/brands', 'route' => 'central_admin.brands'],
];

foreach ($resources as $key => $res) {
    $dir = __DIR__ . '/resources/views/' . $res['path'];
    if (!is_dir($dir)) mkdir($dir, 0777, true);

    // Index
    $index = '<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">จัดการ ' . $res['name_th'] . '</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route(\'' . $res['route'] . '.create\') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">เพิ่ม ' . $res['name_th'] . '</a>
                <table class="w-full mt-4 border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">ID</th>
                            <th class="border p-2">ชื่อ</th>
                            <th class="border p-2">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($' . $key . ' as $item)
                        <tr>
                            <td class="border p-2 text-center">{{ $item->id }}</td>
                            <td class="border p-2">{{ $item->name }}</td>
                            <td class="border p-2 text-center">
                                <a href="{{ route(\'' . $res['route'] . '.edit\', $item) }}" class="text-blue-500 hover:underline">แก้ไข</a> |
                                <form action="{{ route(\'' . $res['route'] . '.destroy\', $item) }}" method="POST" class="inline" onsubmit="return confirm(\'ยืนยันการลบ?\')">
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

    // Create & Edit (Combined logic for simplicity)
    $form = '<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ isset($' . rtrim($key, 's') . ') ? "แก้ไข" : "เพิ่ม" }} ' . $res['name_th'] . '</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ isset($' . rtrim($key, 's') . ') ? route(\'' . $res['route'] . '.update\', $' . rtrim($key, 's') . ') : route(\'' . $res['route'] . '.store\') }}" method="POST">
                    @csrf
                    @if(isset($' . rtrim($key, 's') . ')) @method("PUT") @endif
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">ชื่อ ' . $res['name_th'] . '</label>
                        <input type="text" name="name" value="{{ old(\'name\', $' . rtrim($key, 's') . '->name ?? \'\') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">บันทึก</button>
                    <a href="{{ route(\'' . $res['route'] . '.index\') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 ml-2">ยกเลิก</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>';

    file_put_contents("$dir/create.blade.php", $form);
    file_put_contents("$dir/edit.blade.php", $form);
}
echo "Category and Brand Views Generated.\n";
