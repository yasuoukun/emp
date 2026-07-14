<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ส่งแจ้งเตือนโปรโมชัน') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen fade-in">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-8 bg-white border-b border-gray-200">
                    
                    @if(session('success'))
                        <div class="mb-6 bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-100 flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-xl"></i>
                            <div>
                                <h4 class="font-bold">สำเร็จ!</h4>
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('central_admin.notifications.send') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">หัวข้อแจ้งเตือน <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" required placeholder="เช่น โปรโมชันลดกระหน่ำ 50%!" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            @error('title') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">รายละเอียด (ข้อความ) <span class="text-rose-500">*</span></label>
                            <textarea name="message" rows="4" required placeholder="ใส่รายละเอียดโปรโมชัน..." class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"></textarea>
                            @error('message') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">ลิงก์แนบ (URL)</label>
                            <input type="url" name="url" placeholder="https://..." class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <p class="text-gray-400 text-xs mt-1">ใส่ลิงก์เพื่อให้ลูกค้ากดเข้าไปดูเพิ่มเติม</p>
                            @error('url') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-2">แนบรูปภาพโปรโมชัน</label>
                            <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                            @error('image') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-3 bg-indigo-600 rounded-lg text-sm font-medium text-white hover:bg-indigo-700 transition-colors shadow-md flex items-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i> ส่งแจ้งเตือนให้ลูกค้าทุกคน
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
