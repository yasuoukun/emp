<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign keys and truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Category::truncate();
        Brand::truncate();
        Product::truncate();
        ProductImage::truncate();
        \App\Models\Coupon::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Seed Users
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@dditcom.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin'
        ]);

        User::create([
            'name' => 'General Admin',
            'email' => 'general_admin@dditcom.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Customer Test',
            'email' => 'customer@dditcom.com',
            'password' => bcrypt('password'),
            'role' => 'customer'
        ]);

        // 2. Seed Categories
        $catIphone = Category::create(['name' => 'iPhone (ไอโฟน)']);
        $catSamsung = Category::create(['name' => 'Samsung (ซัมซุง)']);
        $catIpad = Category::create(['name' => 'iPad & Tablet']);
        $catMacbook = Category::create(['name' => 'Computer & Laptop']);
        $catAccessory = Category::create(['name' => 'Accessories (อุปกรณ์เสริม)']);
        $catNetwork = Category::create(['name' => 'Network & Office']);
        $catUsed = Category::create(['name' => 'Second Hand (สินค้ามือสอง)']);

        // 3. Seed Brands
        $brandApple = Brand::create(['name' => 'Apple']);
        $brandSamsung = Brand::create(['name' => 'Samsung']);
        $brandOppo = Brand::create(['name' => 'Oppo']);
        $brandVivo = Brand::create(['name' => 'Vivo']);
        $brandXiaomi = Brand::create(['name' => 'Xiaomi']);
        $brandTplink = Brand::create(['name' => 'TP-Link']);
        $brandBelkin = Brand::create(['name' => 'Belkin']);

        // 4. Seed Products
        
        // --- iPhone ---
        $p1 = Product::create([
            'name' => 'iPhone 15 Pro Max (256GB)',
            'description' => 'สมาร์ทโฟนตัวท็อปจาก Apple ชิป A17 Pro ดีไซน์ไทเทเนียมกล้อง 5x Optical Zoom หน้าจอ Super Retina XDR 6.7 นิ้ว แข็งแกร่งทนทานด้วย Ceramic Shield น้ำหนักเบาลง จับถนัดมือยิ่งขึ้น',
            'price' => 48900.00,
            'discount_price' => 45900.00,
            'stock' => 15,
            'category_id' => $catIphone->id,
            'brand_id' => $brandApple->id,
            'is_promotion' => true,
            'is_popular' => true,
        ]);
        ProductImage::create([
            'product_id' => $p1->id,
            'image_path' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&q=80&w=600',
            'is_primary' => true
        ]);

        $p1_2 = Product::create([
            'name' => 'iPhone 15 (128GB)',
            'description' => 'มาพร้อม Dynamic Island, กล้องหลัก 48MP และ USB-C ดีไซน์กระจกแต่งสีสุดทนทานและอะลูมิเนียม ชิป A16 Bionic ประสิทธิภาพเหนือระดับ',
            'price' => 32900.00,
            'discount_price' => 29900.00,
            'stock' => 20,
            'category_id' => $catIphone->id,
            'brand_id' => $brandApple->id,
            'is_promotion' => true,
            'is_popular' => false,
        ]);
        ProductImage::create([
            'product_id' => $p1_2->id,
            'image_path' => 'https://images.unsplash.com/photo-1616348436168-de43ad0db179?auto=format&fit=crop&q=80&w=600',
            'is_primary' => true
        ]);

        // --- Samsung ---
        $p2 = Product::create([
            'name' => 'Samsung Galaxy S24 Ultra (512GB)',
            'description' => 'ที่สุดแห่งสมาร์ทโฟนฝั่ง Android พร้อมฟีเจอร์ Galaxy AI อัจฉริยะ ซูมชัด 100 เท่า ปากกา S Pen ในตัว หน้าจอ Dynamic AMOLED 2X สว่างสู้แดดดีเยี่ยม ทรงประสิทธิภาพด้วยชิป Snapdragon 8 Gen 3',
            'price' => 49900.00,
            'discount_price' => 43900.00,
            'stock' => 10,
            'category_id' => $catSamsung->id,
            'brand_id' => $brandSamsung->id,
            'is_promotion' => true,
            'is_popular' => true,
        ]);
        ProductImage::create([
            'product_id' => $p2->id,
            'image_path' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?auto=format&fit=crop&q=80&w=600',
            'is_primary' => true
        ]);

        // --- iPad ---
        $p3 = Product::create([
            'name' => 'iPad Pro 11-inch (M4, 256GB)',
            'description' => 'จอภาพ Ultra Retina XDR แบบ Tandem OLED ชิป M4 ใหม่ล่าสุด บางเฉียบ ทรงพลังสูงสุด รองรับ Apple Pencil Pro และ Magic Keyboard รุ่นใหม่ เหมาะสำหรับมืออาชีพและงานสร้างสรรค์ทุกรูปแบบ',
            'price' => 39900.00,
            'discount_price' => 38500.00,
            'stock' => 8,
            'category_id' => $catIpad->id,
            'brand_id' => $brandApple->id,
            'is_popular' => true,
        ]);
        ProductImage::create([
            'product_id' => $p3->id,
            'image_path' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&q=80&w=600',
            'is_primary' => true
        ]);

        $p3_2 = Product::create([
            'name' => 'iPad Air 11-inch (M2, 128GB) Wi-Fi',
            'description' => 'ทรงพลังด้วยชิป M2 หน้าจอ Liquid Retina แสนสวยงาม กล้องหน้าแนวนอนความละเอียดสูง รองรับ Apple Pencil Pro และ Magic Keyboard ลำโพงเสียงสเตอริโอแนวนอน',
            'price' => 23900.00,
            'discount_price' => 21900.00,
            'stock' => 14,
            'category_id' => $catIpad->id,
            'brand_id' => $brandApple->id,
            'is_promotion' => true,
            'is_popular' => false,
        ]);
        ProductImage::create([
            'product_id' => $p3_2->id,
            'image_path' => 'https://images.unsplash.com/photo-1589739900243-4b52cd9b104e?auto=format&fit=crop&q=80&w=600',
            'is_primary' => true
        ]);

        // --- Computers & Laptops ---
        $p_mac1 = Product::create([
            'name' => 'MacBook Air 13-inch (M3, 8GB/256GB)',
            'description' => 'ชิป M3 สุดล้ำ บางเฉียบและน้ำหนักเบา แบตเตอรี่ใช้งานได้นานสูงสุด 18 ชั่วโมง จอภาพ Liquid Retina 13.6 นิ้ว สีสันสดใส คีย์บอร์ด Magic Keyboard พร้อม Touch ID สะดวกและปลอดภัย',
            'price' => 39900.00,
            'discount_price' => 36900.00,
            'stock' => 6,
            'category_id' => $catMacbook->id,
            'brand_id' => $brandApple->id,
            'is_popular' => true,
        ]);
        ProductImage::create([
            'product_id' => $p_mac1->id,
            'image_path' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&q=80&w=600',
            'is_primary' => true
        ]);

        $p_mac2 = Product::create([
            'name' => 'MacBook Pro 14-inch (M3 Pro, 18GB/512GB)',
            'description' => 'จอภาพ Liquid Retina XDR ชิป M3 Pro ทรงพลัง สำหรับนักพัฒนาโปรแกรม ครีเอเตอร์ ช่างภาพ และงานกราฟิกระดับสูง แบตเตอรี่ใช้งานได้ยาวนานอย่างไม่น่าเชื่อ พอร์ตการเชื่อมต่อครบครัน',
            'price' => 79900.00,
            'discount_price' => 75900.00,
            'stock' => 4,
            'category_id' => $catMacbook->id,
            'brand_id' => $brandApple->id,
            'is_promotion' => true,
            'is_popular' => true,
        ]);
        ProductImage::create([
            'product_id' => $p_mac2->id,
            'image_path' => 'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?auto=format&fit=crop&q=80&w=600',
            'is_primary' => true
        ]);

        // --- Accessories ---
        $p4 = Product::create([
            'name' => 'Apple AirPods Pro (Gen 2)',
            'description' => 'ระบบตัดเสียงรบกวนแบบแอกทีฟที่ดีขึ้นสูงสุด 2 เท่า โหมดฟังเสียงภายนอกที่ปรับตามสภาพแวดล้อม และระบบเสียงตามตำแหน่งส่วนบุคคล เคสชาร์จ MagSafe พร้อมลำโพงในตัวและห่วงคล้องสาย',
            'price' => 8990.00,
            'discount_price' => 7990.00,
            'stock' => 25,
            'category_id' => $catAccessory->id,
            'brand_id' => $brandApple->id,
            'is_promotion' => true,
            'is_popular' => false,
        ]);
        ProductImage::create([
            'product_id' => $p4->id,
            'image_path' => 'https://images.unsplash.com/photo-1588449668338-d13417f16af1?auto=format&fit=crop&q=80&w=600',
            'is_primary' => true
        ]);

        $p4_2 = Product::create([
            'name' => 'Apple USB-C Power Adapter 20W',
            'description' => 'อะแดปเตอร์แปลงไฟ Apple USB-C ขนาด 20 วัตต์ สามารถชาร์จได้อย่างรวดเร็วและมีประสิทธิภาพไม่ว่าจะที่บ้าน ที่ทำงาน หรือระหว่างเดินทาง ใช้ร่วมกับอุปกรณ์ที่รองรับ USB-C',
            'price' => 790.00,
            'discount_price' => 690.00,
            'stock' => 50,
            'category_id' => $catAccessory->id,
            'brand_id' => $brandApple->id,
            'is_popular' => false,
        ]);
        ProductImage::create([
            'product_id' => $p4_2->id,
            'image_path' => 'https://images.unsplash.com/photo-1608248597481-496100c80836?auto=format&fit=crop&q=80&w=600',
            'is_primary' => true
        ]);

        $p4_3 = Product::create([
            'name' => 'Belkin BoostCharge Pro 3-in-1 Wireless Charger',
            'description' => 'แท่นชาร์จไร้สาย 3-in-1 ชาร์จ iPhone, Apple Watch และ AirPods ได้พร้อมกันอย่างรวดเร็ว ดีไซน์สวยหรูพรีเมียมด้วยวัสดุคุณภาพสูง รองรับ MagSafe สูงสุด 15W',
            'price' => 5990.00,
            'discount_price' => 4990.00,
            'stock' => 12,
            'category_id' => $catAccessory->id,
            'brand_id' => $brandBelkin->id,
            'is_promotion' => true,
            'is_popular' => false,
        ]);
        ProductImage::create([
            'product_id' => $p4_3->id,
            'image_path' => 'https://images.unsplash.com/photo-1622445262465-2481c4574875?auto=format&fit=crop&q=80&w=600',
            'is_primary' => true
        ]);

        // --- Other Brands ---
        $p5 = Product::create([
            'name' => 'Oppo Reno 11 Pro 5G',
            'description' => 'สมาร์ทโฟนดีไซน์สวยหรู กล้องพอร์ตเทรตสวยสะกดระดับสตูดิโอ ชาร์จไว 80W SuperVOOC หน้าจอขอบโค้ง 3D มอบประสบการณ์ใช้งานที่ลื่นไหลล้ำหน้า',
            'price' => 19990.00,
            'discount_price' => 17990.00,
            'stock' => 12,
            'category_id' => $catIphone->id, // Classified as Smartphone
            'brand_id' => $brandOppo->id,
            'is_promotion' => true,
            'is_popular' => false,
        ]);
        ProductImage::create([
            'product_id' => $p5->id,
            'image_path' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&q=80&w=600',
            'is_primary' => true
        ]);

        $p_xiaomi = Product::create([
            'name' => 'Xiaomi 14 Ultra (512GB)',
            'description' => 'กล้องสมาร์ทโฟนระดับตำนาน Leica Summilux เซ็นเซอร์ใหญ่พิเศษ 1 นิ้ว ถ่ายภาพระดับมืออาชีพ ชิปเซ็ตประมวลผลแรงที่สุด Snapdragon 8 Gen 3 จอภาพคมชัด 120Hz',
            'price' => 40990.00,
            'discount_price' => 37990.00,
            'stock' => 7,
            'category_id' => $catIphone->id,
            'brand_id' => $brandXiaomi->id,
            'is_popular' => true,
        ]);
        ProductImage::create([
            'product_id' => $p_xiaomi->id,
            'image_path' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&q=80&w=600',
            'is_primary' => true
        ]);

        // --- Network ---
        $p_net1 = Product::create([
            'name' => 'TP-Link Archer AX55 Wi-Fi 6 Router',
            'description' => 'เราเตอร์ความเร็วสูงเทคโนโลยี Wi-Fi 6 (802.11ax) ความเร็วไร้สายรวมสูงสุด 3000 Mbps เสาสัญญาณ 4 เสา ให้สัญญาณครอบคลุมพื้นที่กว้างไกล รองรับการเชื่อมต่ออุปกรณ์จำนวนมาก',
            'price' => 2990.00,
            'discount_price' => 2490.00,
            'stock' => 18,
            'category_id' => $catNetwork->id,
            'brand_id' => $brandTplink->id,
            'is_popular' => false,
        ]);
        ProductImage::create([
            'product_id' => $p_net1->id,
            'image_path' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&q=80&w=600',
            'is_primary' => true
        ]);

        // --- Used Products ---
        $p_used1 = Product::create([
            'name' => '[มือสอง] iPhone 13 Pro (128GB) - สภาพ 95%',
            'description' => 'สินค้ามือสองสภาพสวยงามมาก ทำงานได้สมบูรณ์ 100% สุขภาพแบตเตอรี่ 88% กล้องสามตัวรองรับโหมดภาพยนตร์ อุปกรณ์ครบกล่อง รับประกันหลังการขายจากบริษัท 3 เดือน',
            'price' => 22900.00,
            'discount_price' => 18900.00,
            'stock' => 2,
            'category_id' => $catUsed->id,
            'brand_id' => $brandApple->id,
            'is_promotion' => true,
            'is_popular' => false,
        ]);
        ProductImage::create([
            'product_id' => $p_used1->id,
            'image_path' => 'https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?auto=format&fit=crop&q=80&w=600',
            'is_primary' => true
        ]);

        $p_used2 = Product::create([
            'name' => '[มือสอง] iPad Air 4 (64GB) Wi-Fi - สภาพ 90%',
            'description' => 'แท็บเล็ตมือสองสภาพดี มีริ้วรอยเล็กน้อยตามการใช้งานทั่วไป หน้าจอสวยงามไร้จุดเสีย จอสัมผัสไหลลื่น รองรับ Apple Pencil 2 พร้อมรับประกันเครื่องยาวนาน 90 วัน',
            'price' => 14900.00,
            'discount_price' => 10900.00,
            'stock' => 3,
            'category_id' => $catUsed->id,
            'brand_id' => $brandApple->id,
            'is_promotion' => false,
            'is_popular' => false,
        ]);
        ProductImage::create([
            'product_id' => $p_used2->id,
            'image_path' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&q=80&w=600',
            'is_primary' => true
        ]);

        // 5. Seed Coupons
        \App\Models\Coupon::create([
            'code' => 'DDIT100',
            'name' => 'คูปองกิจกรรมต้อนรับเปิดเทอม (เฉพาะสินค้า AirPods)',
            'product_id' => $p4->id, // Associated with AirPods Pro
            'discount_amount' => 100.00,
            'expires_at' => now()->addDays(5)->toDateTimeString(), // 5 days countdown
        ]);
        \App\Models\Coupon::create([
            'code' => 'DDIT500',
            'name' => 'คูปองกิจกรรมวันแม่แห่งชาติ (ลดทั้งร้าน)',
            'discount_amount' => 500.00,
            'expires_at' => now()->addDays(10)->toDateTimeString(), // 10 days countdown
        ]);
        \App\Models\Coupon::create([
            'code' => 'DDIT1000',
            'name' => 'คูปองโปรโมชันใหญ่ประจำปี (ลดทั้งร้าน)',
            'discount_amount' => 1000.00,
            'expires_at' => now()->addDays(15)->toDateTimeString(), // 15 days countdown
        ]);
    }
}
