<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ isset($categorie) ? "แก้ไข" : "เพิ่ม" }} หมวดหมู่</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ isset($categorie) ? route('central_admin.categories.update', $categorie) : route('central_admin.categories.store') }}" method="POST">
                    @csrf
                    @if(isset($categorie)) @method("PUT") @endif
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">ชื่อ หมวดหมู่</label>
                        <input type="text" name="name" value="{{ old('name', $categorie->name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">บันทึก</button>
                    <a href="{{ route('central_admin.categories.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 ml-2">ยกเลิก</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>