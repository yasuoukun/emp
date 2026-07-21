@extends('layouts.store')

@section('content')
<div class="container" style="max-width: 1000px; margin: 0 auto; padding: 3rem 1rem;">
    <!-- Premium Header -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <span style="background: rgba(27, 42, 71, 0.08); color: var(--color-navy); font-size: 0.9rem; font-weight: 600; padding: 6px 16px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px;">Service Center</span>
        <h1 style="font-size: 2.5rem; font-weight: 700; color: var(--color-navy-dark); margin: 10px 0 15px; font-family: 'Prompt', sans-serif;">ศูนย์บริการแจ้งเคลมและส่งซ่อม</h1>
        <p style="color: var(--color-grey); max-width: 600px; margin: 0 auto; font-size: 1.05rem; line-height: 1.6;">แจ้งซ่อมอุปกรณ์เสีย ส่งเคลมเคลมประกันศูนย์ หรือตั้งค่าลงโปรแกรมเครื่องใหม่ ทำรายการบันทึกเข้าระบบหลังบ้านได้ทันที</p>
    </div>

    <!-- Service Offerings -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 4rem;">
        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 12px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); text-align: center;">
            <div style="font-size: 2.5rem; margin-bottom: 1rem; color: #ef4444;">🛡️</div>
            <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-bottom: 10px;">ส่งเคลมประกันศูนย์</h3>
            <p style="color: var(--color-grey); font-size: 0.9rem; line-height: 1.6;">สินค้าประกันศูนย์ iCare / AppleCare+ สามารถส่งเคลมบอร์ด จอ แบตเตอรี่ ชิ้นส่วนแท้ 100%</p>
        </div>
        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 12px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); text-align: center;">
            <div style="font-size: 2.5rem; margin-bottom: 1rem; color: var(--color-navy);">🔧</div>
            <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-bottom: 10px;">ซ่อมด่วนเครื่องหมดประกัน</h3>
            <p style="color: var(--color-grey); font-size: 0.9rem; line-height: 1.6;">รับซ่อมเปลี่ยนหน้าจอร้าว แบตเสื่อม ปรับปรุงซ่อมเมนบอร์ด โดยช่างผู้เชี่ยวชาญพร้อมรับประกันงานซ่อม</p>
        </div>
        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 12px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); text-align: center;">
            <div style="font-size: 2.5rem; margin-bottom: 1rem; color: #FFD700;">⚙️</div>
            <h3 style="color: var(--color-navy-dark); font-weight: 700; margin-bottom: 10px;">บริการตั้งค่า/ลงโปรแกรม</h3>
            <p style="color: var(--color-grey); font-size: 0.9rem; line-height: 1.6;">บริการช่วยตั้งค่าเครื่องใหม่ สมัคร Apple ID ย้ายข้อมูลข้ามเครื่อง และบริการแก้ปัญหาระบบ iOS/macOS</p>
        </div>
    </div>

    <!-- Booking Form & Info Split -->
    <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 3rem; align-items: start;">
        <!-- Form Box -->
        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 16px; padding: 2.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
            <h3 style="font-size: 1.4rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 1.5rem;">📝 ฟอร์มแจ้งขอเคลม / ซ่อม / ตั้งค่า</h3>
            
            <form action="{{ route('claims.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 5px; color: var(--color-navy-dark); font-size: 0.9rem;">ชื่อ-นามสกุล ผู้แจ้ง</label>
                        <input type="text" name="customer_name" required value="{{ auth()->check() ? auth()->user()->name : '' }}" style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 8px; outline: none;" onfocus="this.style.borderColor='var(--color-navy)'" onblur="this.style.borderColor='var(--color-silver)'">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 5px; color: var(--color-navy-dark); font-size: 0.9rem;">เบอร์โทรศัพท์ติดต่อ</label>
                        <input type="tel" name="customer_phone" required value="{{ auth()->check() ? auth()->user()->phone : '' }}" style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 8px; outline: none;" onfocus="this.style.borderColor='var(--color-navy)'" onblur="this.style.borderColor='var(--color-silver)'">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 5px; color: var(--color-navy-dark); font-size: 0.9rem;">ชื่ออุปกรณ์ / รุ่นสินค้า</label>
                        <input type="text" name="device_name" required placeholder="เช่น iPhone 15 Pro, iPad Air 5" style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 8px; outline: none;" onfocus="this.style.borderColor='var(--color-navy)'" onblur="this.style.borderColor='var(--color-silver)'">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 5px; color: var(--color-navy-dark); font-size: 0.9rem;">เลขซีเรียล / Serial Number</label>
                        <input type="text" name="serial_number" placeholder="เช่น DX3D..." style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 8px; outline: none;" onfocus="this.style.borderColor='var(--color-navy)'" onblur="this.style.borderColor='var(--color-silver)'">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 5px; color: var(--color-navy-dark); font-size: 0.9rem;">ประเภทบริการ</label>
                        <select name="claim_type" required style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 8px; font-family: inherit; font-size: 0.9rem;">
                            <option value="repair">🔧 บริการซ่อมของร้าน (ช่างผู้เชี่ยวชาญ)</option>
                            <option value="warranty">🛡️ บริการเคลมประกันสินค้า</option>
                            <option value="setting">⚙️ ตั้งค่า/ลงโปรแกรม/อัปเดต</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 5px; color: var(--color-navy-dark); font-size: 0.9rem;">เลขออเดอร์อ้างอิง (ถ้ามี)</label>
                        <input type="text" name="order_id_raw" placeholder="เช่น ORD-..." style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 8px; outline: none;" onfocus="this.style.borderColor='var(--color-navy)'" onblur="this.style.borderColor='var(--color-silver)'">
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 5px; color: var(--color-navy-dark); font-size: 0.9rem;">รายละเอียดปัญหา / อาการเสียที่พบ</label>
                    <textarea name="issue_description" required rows="3" placeholder="ระบุอาการชำรุด อาการเสีย หรือบริการตั้งค่าที่ต้องการอย่างละเอียด..." style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 8px; outline: none; font-family: inherit;" onfocus="this.style.borderColor='var(--color-navy)'" onblur="this.style.borderColor='var(--color-silver)'"></textarea>
                </div>

                <!-- Multi-image Upload Input -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 5px; color: var(--color-navy-dark); font-size: 0.9rem;">📷 แนบรูปถ่ายสภาพตัวเครื่องหรืออาการเสีย (สามารถเลือกได้หลายรูป)</label>
                    <input type="file" name="images[]" multiple accept="image/*" style="width: 100%; padding: 8px; border: 1px dashed var(--color-silver); border-radius: 8px; background: var(--color-grey-bg); font-size: 0.85rem;">
                    <span style="font-size: 0.75rem; color: #64748b; display: block; margin-top: 4px;">รองรับไฟล์ PNG, JPG, JPEG, WEBP ขนาดไม่เกิน 4MB ต่อรูป</span>
                </div>

                <button type="submit" style="background: var(--color-navy-dark); color: white; font-weight: 600; border: none; padding: 12px 25px; border-radius: 8px; width: 100%; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='var(--color-navy)'" onmouseout="this.style.background='var(--color-navy-dark)'">
                    💾 บันทึกและส่งซ่อมของร้าน
                </button>
            </form>
        </div>

        <!-- Info Column -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Track claim box -->
            <div style="background: linear-gradient(135deg, var(--color-navy-dark) 0%, var(--color-navy) 100%); color: white; border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(27,42,71,0.15);">
                <h4 style="font-weight: 700; margin-top: 0; margin-bottom: 10px; color: #FFD700; font-size: 1.25rem;">🔍 ติดตามสถานะงานซ่อม/เคลม</h4>
                <p style="color: var(--color-silver); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;">เมื่อคุณบันทึกฟอร์มเสร็จสิ้น ระบบจะสร้างหมายเลขใบเคลม (Claim Code) ให้ใช้สำหรับตรวจเช็คสถานะการดำเนินการได้ตลอด 24 ชั่วโมง</p>
                <a href="{{ route('tracking', ['type' => 'claim']) }}" style="display: inline-block; background: white; color: var(--color-navy-dark); padding: 10px 20px; border-radius: 8px; font-weight: 700; text-decoration: none; font-size: 0.9rem; text-align: center; width: 100%;">
                    เข้าสู่หน้าเช็คสถานะทันที
                </a>
            </div>

            <!-- Shop details -->
            <div style="background: var(--color-grey-bg); border-radius: 16px; padding: 2rem; border: 1px solid var(--color-silver);">
                <h4 style="color: var(--color-navy-dark); font-weight: 700; margin-top: 0; margin-bottom: 10px;">📍 ส่งอุปกรณ์มาตามที่อยู่นี้</h4>
                <p style="color: var(--color-grey); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1rem;">หากท่านกรอกฟอร์มบริการแบบส่งพัสดุ กรุณาส่งตัวเครื่องที่แพ็คกันกระแทกอย่างดีมาที่:</p>
                <div style="background: white; border: 1px solid var(--color-silver); padding: 12px; border-radius: 8px; font-size: 0.85rem; color: var(--color-navy-dark); font-family: monospace; margin-bottom: 1.5rem; line-height: 1.5;">
                    ผู้รับ: ฝ่ายเคลมและบริการ บริษัท ดีดี.ไอที.คอม จำกัด<br>
                    ที่อยู่: 72/47-48ก ถนนชัยประสิทธิ์ ต.ในเมือง อ.เมือง จ.ชัยภูมิ 36000<br>
                    โทร: 083-828-941
                </div>
                <p style="color: var(--color-grey); font-size: 0.85rem; margin-bottom: 0;">*กรุณาเขียนหมายเลขใบเคลม (CLM-XXXXXX) กำกับบนหน้ากล่องพัสดุเพื่อให้เจ้าหน้าที่คัดแยกเครื่องและดำเนินงานได้รวดเร็วขึ้น</p>
            </div>
        </div>
    </div>
</div>
@endsection
