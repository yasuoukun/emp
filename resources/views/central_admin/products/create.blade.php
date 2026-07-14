<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-plus text-indigo-600"></i>
            {{ "เพิ่มสินค้าใหม่" }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100 p-8">
                
                <form action="{{ route('central_admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">ชื่อสินค้า</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="เช่น iPhone 15 Pro Max" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">สต็อก (จำนวนคงเหลือ)</label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required min="0">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">ราคาเต็ม (บาท)</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="เช่น 35000" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">ราคาลด/ราคาโปรโมชัน (เว้นว่างถ้าไม่มี)</label>
                            <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price') }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="เช่น 32900">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">หมวดหมู่สินค้า</label>
                            <select name="category_id" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">-- เลือกหมวดหมู่ --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">แบรนด์สินค้า</label>
                            <select name="brand_id" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">-- เลือกแบรนด์ --</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">รายละเอียดสินค้า</label>
                        <textarea name="description" rows="4" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="อธิบายรายละเอียด ประกันศูนย์ ฯลฯ">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">ของแถม (Freebie / Gift)</label>
                            <input type="text" name="freebie" value="{{ old('freebie') }}" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="เช่น เคสใส + ฟิล์มกระจกกันรอย">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">สเปกสินค้า (Specifications)</label>
                            <textarea name="specifications" rows="2" class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="เช่น ชิป A17 Pro, จอ Super Retina XDR 6.7 นิ้ว, กล้อง 48MP">{{ old('specifications') }}</textarea>
                        </div>
                    </div>

                    <!-- Upload Input with AlpineJS Preview -->
                    <div class="mb-8" x-data="{ previewImages: [] }">
                        <label class="block text-sm font-bold text-slate-700 mb-2">รูปภาพสินค้า (อัปโหลดหลายรูปภาพได้)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-2xl bg-slate-50/50 hover:bg-slate-50 transition relative">
                            <div class="space-y-1 text-center">
                                <i class="fa-solid fa-images text-slate-400 text-3xl mb-2"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label class="relative cursor-pointer bg-white rounded-md font-semibold text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>คลิกเพื่ออัปโหลดไฟล์ภาพ</span>
                                        <input type="file" name="images[]" accept="image/*" @change="previewImages = Array.from($event.target.files).map(file => URL.createObjectURL(file))" multiple class="sr-only">
                                    </label>
                                </div>
                                <p class="text-xs text-slate-400">PNG, JPG, JPEG, WEBP ขนาดไม่เกิน 2MB ต่อรูปภาพ</p>
                            </div>
                        </div>

                        <!-- Preview Grid -->
                        <div x-show="previewImages.length > 0" class="mt-6" style="display: none;">
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check text-indigo-500"></i> ตัวอย่างรูปภาพที่คุณเลือก (รูปแรกจะเป็นภาพหน้าปกอัตโนมัติ)
                            </h4>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <template x-for="(url, idx) in previewImages" :key="idx">
                                    <div class="border rounded-2xl p-2 bg-indigo-50/20 flex flex-col items-center justify-between relative shadow-sm border-indigo-100">
                                        <img :src="url" class="h-24 object-contain rounded-xl">
                                        <span class="text-[10px] text-indigo-600 mt-2 font-bold px-2 py-0.5 bg-indigo-50 rounded-full" x-text="idx === 0 ? '★ รูปหน้าปกหลัก' : 'รูปประกอบที่ ' + idx"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('central_admin.products.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition shadow-sm">
                            ยกเลิก
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition shadow-sm">
                            บันทึกข้อมูลสินค้า
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>