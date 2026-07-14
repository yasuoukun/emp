<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomepageSetting;
use App\Models\PromotionalBanner;
use Illuminate\Support\Facades\Storage;

class CmsController extends Controller
{
    public function index()
    {
        $settings = [
            'slogan_badge' => HomepageSetting::get('slogan_badge', '🔥 โปรโมชันพิเศษ ลดสูงสุด 50%'),
            'slogan_title' => HomepageSetting::get('slogan_title', 'dd.it.com จัดเต็มโปรโมชัน!'),
            'slogan_description' => HomepageSetting::get('slogan_description', "สมาร์ทโฟน แก็ดเจ็ต และบริการซ่อมมือถือครบวงจร\nพร้อมประกันศูนย์และบริการหลังการขายระดับพรีเมียม"),
        ];

        $banners = PromotionalBanner::orderBy('sort_order')->get();

        return view('admin.cms.index', compact('settings', 'banners'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'slogan_badge' => 'nullable|string|max:100',
            'slogan_title' => 'required|string|max:200',
            'slogan_description' => 'nullable|string|max:1000',
        ]);

        foreach ($validated as $key => $val) {
            HomepageSetting::set($key, $val);
        }

        return redirect()->back()->with('success', 'บันทึกการตั้งค่าคำโฆษณา Slogan เรียบร้อยแล้ว');
    }

    public function storeBanner(Request $request)
    {
        $request->validate([
            'banner_image' => 'required_without:image_url|nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'image_url' => 'required_without:banner_image|nullable|url|max:1000',
            'link_url' => 'nullable|url|max:255',
            'sort_order' => 'required|integer|min:0',
        ], [
            'banner_image.required_without' => 'กรุณาอัปโหลดไฟล์รูปภาพ หรือกรอกลิงก์รูปภาพออนไลน์อย่างใดอย่างหนึ่ง',
            'image_url.required_without' => 'กรุณาอัปโหลดไฟล์รูปภาพ หรือกรอกลิงก์รูปภาพออนไลน์อย่างใดอย่างหนึ่ง',
            'image_url.url' => 'ลิงก์รูปภาพออนไลน์ต้องเป็นรูปแบบ URL ที่ถูกต้อง (เช่น https://...)',
            'link_url.url' => 'ลิงก์เชื่อมโยงต้องเป็นรูปแบบ URL ที่ถูกต้อง (เช่น https://...)',
        ]);

        $imagePath = '';
        if ($request->hasFile('banner_image')) {
            $imagePath = $request->file('banner_image')->store('banners', 'public');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        PromotionalBanner::create([
            'image_path' => $imagePath,
            'link_url' => $request->link_url,
            'sort_order' => $request->sort_order,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'เพิ่มสไลด์แบนเนอร์ใหม่เรียบร้อยแล้ว');
    }

    public function deleteBanner(PromotionalBanner $banner)
    {
        // Delete image file from storage if it is a local file path
        if (!str_starts_with($banner->image_path, 'http') && Storage::disk('public')->exists($banner->image_path)) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $banner->delete();

        return redirect()->back()->with('success', 'ลบสไลด์แบนเนอร์ออกเรียบร้อยแล้ว');
    }
}
