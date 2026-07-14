<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-window-restore text-indigo-600"></i>
            ตกแต่งหน้าแรกและระบบจัดการ CMS
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
            <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-800 rounded-r-lg shadow-sm flex flex-col gap-1.5">
                <div class="flex items-center gap-3 font-semibold mb-1">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500 text-xl"></i>
                    <span>เกิดข้อผิดพลาดในการดำเนินงาน:</span>
                </div>
                <ul class="list-disc list-inside text-sm space-y-0.5 pl-6 font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Column 1: Slogan Settings Form -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm lg:col-span-1 h-fit">
                    <h3 class="font-bold text-lg text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-pen-nib text-indigo-600"></i>
                        คำโฆษณาและสโลแกนหน้าแรก
                    </h3>
                    <p class="text-xs text-gray-400 mb-6">ข้อความนี้จะแสดงในส่วน Hero Banner ด้านบนสุดของหน้าแรกเพื่อดึงดูดลูกค้า</p>

                    <form action="{{ route('central_admin.cms.update_settings') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">ข้อความ Badge (หัวข้อสีเด่น)</label>
                            <input type="text" name="slogan_badge" value="{{ $settings['slogan_badge'] }}" placeholder="เช่น 🔥 โปรโมชันพิเศษ!" 
                                   class="w-full rounded-xl border-gray-200 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-medium">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">หัวข้อ Slogan หลัก (ตัวหนาขนาดใหญ่)</label>
                            <input type="text" name="slogan_title" value="{{ $settings['slogan_title'] }}" required placeholder="เช่น ดีดี.ไอที.คอม ยินดีต้อนรับ" 
                                   class="w-full rounded-xl border-gray-200 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-medium">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">รายละเอียดสโลแกน</label>
                            <textarea name="slogan_description" rows="4" placeholder="ระบุข้อความบรรยายสั้นๆ..." 
                                      class="w-full rounded-xl border-gray-200 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-medium">{{ $settings['slogan_description'] }}</textarea>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition shadow-md">
                            บันทึกการตั้งค่า
                        </button>
                    </form>
                </div>

                <!-- Column 2 & 3: Banners Management -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Upload Banner Form -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-lg text-slate-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-circle-plus text-indigo-600"></i>
                            อัปโหลดรูปภาพสไลด์แบนเนอร์ใหม่
                        </h3>
                        
                        <form action="{{ route('central_admin.cms.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4 border border-indigo-100 bg-indigo-50/20 rounded-2xl">
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5 flex items-center gap-1.5">
                                        <span class="bg-indigo-600 text-white text-[10px] px-1.5 py-0.5 rounded-full">วิธีที่ 1</span>
                                        วางลิงก์รูปภาพออนไลน์ (ง่ายและแนะนำมากที่สุด ⚡)
                                    </label>
                                    <input type="url" name="image_url" placeholder="เช่น https://imgur.com/your-image.jpg" 
                                           class="w-full rounded-xl border-gray-200 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-medium bg-white">
                                    <span class="text-[10px] text-gray-400 block mt-1">สามารถนำลิงก์รูปภาพจากเว็บฝากรูปต่าง ๆ เช่น Imgur หรือ Discord มาใส่ได้ทันที</span>
                                </div>

                                <div class="p-4 border border-gray-150 bg-gray-50/50 rounded-2xl">
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5 flex items-center gap-1.5">
                                        <span class="bg-slate-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">วิธีที่ 2</span>
                                        อัปโหลดไฟล์รูปจากเครื่องคอมพิวเตอร์ของคุณ
                                    </label>
                                    <input type="file" name="banner_image" 
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 border border-gray-200 rounded-xl p-1 bg-white">
                                    <span class="text-[10px] text-gray-400 block mt-1">แนะนำขนาด 1200x400px (ขนาดไม่เกิน 3MB)</span>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">ลิงก์ URL เมื่อกดรูปภาพ (ไม่บังคับ)</label>
                                    <input type="url" name="link_url" placeholder="https://example.com/promotions" 
                                           class="w-full rounded-xl border-gray-200 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-medium">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">ลำดับการเรียง (Sort Order)</label>
                                    <input type="number" name="sort_order" value="0" min="0" required 
                                           class="w-full rounded-xl border-gray-200 focus:ring-indigo-200 focus:border-indigo-400 text-sm font-medium">
                                </div>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-12 rounded-xl transition shadow-md">
                                    บันทึกและเพิ่มสไลด์แบนเนอร์
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Banners Listing -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-lg text-slate-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-images text-indigo-600"></i>
                            รายการแบนเนอร์ปัจจุบันที่เปิดใช้งาน
                        </h3>
                        <p class="text-xs text-gray-400 mb-6">หากมีการลงทะเบียนรูปภาพสไลด์แบนเนอร์ ระบบหน้าแรกจะสลับมาแสดงแบนเนอร์เหล่านี้แทนภาพสีพื้นหลังเริ่มต้นโดยอัตโนมัติ</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($banners as $banner)
                            <div class="border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition bg-gray-50 flex flex-col justify-between">
                                <div class="aspect-[3/1] bg-gray-200 overflow-hidden relative">
                                    <img src="{{ str_starts_with($banner->image_path, 'http') ? $banner->image_path : Storage::url($banner->image_path) }}" alt="Banner" class="w-full h-full object-cover">
                                    <span class="absolute top-2 left-2 bg-indigo-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm">
                                        ลำดับ: {{ $banner->sort_order }}
                                    </span>
                                </div>
                                <div class="p-3 flex justify-between items-center gap-2 bg-white">
                                    <div class="text-[11px] text-gray-400 truncate flex-grow" title="{{ $banner->link_url }}">
                                        {{ $banner->link_url ? "🔗 {$banner->link_url}" : "❌ ไม่มีลิงก์เชื่อมโยง" }}
                                    </div>
                                    <form action="{{ route('central_admin.cms.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('ยืนยันที่จะลบรูปสไลด์แบนเนอร์นี้?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-50 text-rose-600 hover:bg-rose-100 px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1">
                                            <i class="fa-solid fa-trash-can"></i> ลบรูป
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div class="col-span-2 py-12 text-center text-slate-400">
                                <i class="fa-solid fa-mountain-sun text-4xl mb-2 block"></i>
                                ยังไม่มีภาพสไลด์โฆษณาในระบบ (แสดงผลหน้าพื้นหลังสีดาร์คโหมดของร้านเริ่มต้น)
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
