<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <a href="{{ route('central_admin.articles.index') }}" class="text-gray-500 hover:text-indigo-600 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <span class="text-indigo-600">แก้ไขบทความ</span>
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen fade-in">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-8 bg-white border-b border-gray-200">
                    
                    <form action="{{ route('central_admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">หัวข้อบทความ <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" value="{{ $article->title }}" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            @error('title') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">เนื้อหา <span class="text-rose-500">*</span></label>
                            <textarea name="content" rows="10" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">{{ $article->content }}</textarea>
                            @error('content') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">ชื่อผู้เขียน</label>
                                <input type="text" name="author_name" value="{{ $article->author_name }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                @error('author_name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">เพิ่มรูปภาพใหม่</label>
                                <input type="file" name="images[]" multiple accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                                @error('images.*') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        @if($article->images && count($article->images) > 0)
                        <div class="mb-6 bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <label class="block text-sm font-bold text-gray-700 mb-3">รูปภาพที่มีอยู่ (เลือกเพื่อลบรูปที่ไม่ต้องการออก)</label>
                            <div class="flex flex-wrap gap-4">
                                @foreach($article->images as $img)
                                <div class="relative group">
                                    <img src="{{ Storage::url($img) }}" alt="Image" class="h-24 w-24 object-cover rounded-lg border border-gray-300 shadow-sm">
                                    <label class="absolute -top-2 -right-2 bg-white rounded-full shadow cursor-pointer p-1 group-hover:bg-rose-50 transition-colors">
                                        <input type="checkbox" name="remove_images[]" value="{{ $img }}" class="rounded text-rose-500 focus:ring-rose-400 w-4 h-4 cursor-pointer" title="เลือกลบรูปนี้">
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="mb-8 flex items-center">
                            <input type="checkbox" name="is_published" id="is_published" {{ $article->is_published ? 'checked' : '' }} value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-5 w-5 cursor-pointer">
                            <label for="is_published" class="ml-2 block text-sm text-gray-900 cursor-pointer select-none">
                                <span class="font-bold">สถานะเผยแพร่</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                            <a href="{{ route('central_admin.articles.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                ยกเลิก
                            </a>
                            <button type="submit" class="px-6 py-2 bg-indigo-600 rounded-lg text-sm font-medium text-white hover:bg-indigo-700 transition-colors shadow-md">
                                บันทึกการเปลี่ยนแปลง
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
