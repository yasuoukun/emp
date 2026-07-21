<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-wrench text-indigo-600"></i>
                รายละเอียดงานเคลม/ซ่อม: {{ $claim->id }}
            </span>
            <a href="{{ route('admin.claims.index') }}" class="text-xs bg-indigo-100 text-indigo-800 px-3 py-1.5 rounded-full font-bold hover:bg-indigo-200 transition">
                ⬅️ กลับไปหน้ารวม
            </a>
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Info Section (2 cols) -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Customer and Device Info Card -->
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2">📋 ข้อมูลการแจ้งซ่อม/เคลม</h3>
                        
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-400 block">ชื่อลูกค้า</span>
                                <strong class="text-slate-800">{{ $claim->customer_name }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">เบอร์โทรศัพท์</span>
                                <strong class="text-slate-800">{{ $claim->customer_phone }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">ชื่ออุปกรณ์</span>
                                <strong class="text-slate-800">{{ $claim->device_name }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">หมายเลขซีเรียล (S/N)</span>
                                <strong class="text-slate-800">{{ $claim->serial_number ?? '-' }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">ประเภทงาน</span>
                                @if($claim->claim_type === 'warranty')
                                    <span class="inline-flex px-2.5 py-1 text-xs font-bold bg-emerald-100 text-emerald-800 rounded-full">🛡️ เคลมประกันศูนย์</span>
                                @elseif($claim->claim_type === 'repair')
                                    <span class="inline-flex px-2.5 py-1 text-xs font-bold bg-indigo-100 text-indigo-800 rounded-full">🔧 ส่งซ่อมทั่วไป</span>
                                @else
                                    <span class="inline-flex px-2.5 py-1 text-xs font-bold bg-amber-100 text-amber-800 rounded-full">⚙️ ตั้งค่า/ลงโปรแกรม</span>
                                @endif
                            </div>
                            <div>
                                <span class="text-gray-400 block">เลขออเดอร์อ้างอิง</span>
                                <strong class="text-slate-800">{{ $claim->order_id_raw ?? '-' }}</strong>
                            </div>
                        </div>

                        <div class="pt-4 border-t">
                            <span class="text-gray-400 text-xs block mb-1">อาการเสียที่พบ / บริการที่ต้องการ</span>
                            <div class="bg-slate-50 p-4 rounded-xl text-sm text-slate-700 whitespace-pre-line leading-relaxed">
                                {{ $claim->issue_description }}
                            </div>
                        </div>

                        <!-- Uploaded Device Photos -->
                        @if(!empty($claim->image_paths) && count($claim->image_paths) > 0)
                        <div class="pt-4 border-t">
                            <span class="text-gray-600 text-xs font-bold block mb-2">📷 รูปถ่ายตัวเครื่องหรืออาการเสียจากลูกค้า:</span>
                            <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                                @foreach($claim->image_paths as $img)
                                <a href="{{ Storage::url($img) }}" target="_blank" class="block border rounded-xl overflow-hidden aspect-square bg-gray-100 hover:opacity-80 transition">
                                    <img src="{{ Storage::url($img) }}" alt="Device Photo" class="w-full h-full object-cover">
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Update Status Form Section (1 col) -->
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm h-fit space-y-6">
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2">⚙️ ปรับสถานะงาน</h3>
                    
                    <form action="{{ route('admin.claims.update', $claim->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">เลือกสถานะ:</label>
                            <select name="status" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm font-medium focus:ring-2 focus:ring-indigo-200">
                                <option value="pending" {{ $claim->status === 'pending' ? 'selected' : '' }}>⏳ ได้รับแจ้งเรื่อง (Pending)</option>
                                <option value="received" {{ $claim->status === 'received' ? 'selected' : '' }}>📦 ได้รับเครื่องแล้ว (Received)</option>
                                <option value="in_progress" {{ $claim->status === 'in_progress' ? 'selected' : '' }}>🛠️ กำลังดำเนินการ (In Progress)</option>
                                <option value="completed" {{ $claim->status === 'completed' ? 'selected' : '' }}>✅ เสร็จสิ้นส่งคืน (Completed)</option>
                                <option value="cancelled" {{ $claim->status === 'cancelled' ? 'selected' : '' }}>❌ ยกเลิก (Cancelled)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">💰 ค่าซ่อมเบื้องต้น (บาท):</label>
                            <input type="number" step="0.01" name="estimated_cost" value="{{ $claim->estimated_cost }}" placeholder="เช่น 1500" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm font-medium focus:ring-2 focus:ring-indigo-200">
                            <span class="text-xs text-gray-400 mt-1 block">ระบุประเมินราคาซ่อมเพื่อให้ลูกค้าทราบในระบบ</span>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">บันทึกความคืบหน้า (แจ้งผู้แจ้ง):</label>
                            <textarea name="admin_notes" rows="5" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-200 placeholder-gray-400" placeholder="เช่น ช่างตรวจอาการบอร์ดเสียแล้ว รอสั่งอะไหล่ 3 วัน...">{{ $claim->admin_notes }}</textarea>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm py-3 rounded-xl transition duration-150 shadow-sm shadow-indigo-100">
                            💾 บันทึกอัปเดต
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
