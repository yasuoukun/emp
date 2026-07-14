<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">จัดการ หมวดหมู่</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('central_admin.categories.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">เพิ่ม หมวดหมู่</a>
                <table class="w-full mt-4 border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">ID</th>
                            <th class="border p-2">ชื่อ</th>
                            <th class="border p-2">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $item)
                        <tr>
                            <td class="border p-2 text-center">{{ $item->id }}</td>
                            <td class="border p-2">{{ $item->name }}</td>
                            <td class="border p-2 text-center">
                                <a href="{{ route('central_admin.categories.edit', $item) }}" class="text-blue-500 hover:underline">แก้ไข</a> |
                                <form action="{{ route('central_admin.categories.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('ยืนยันการลบ?')">
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
</x-app-layout>