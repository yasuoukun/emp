@extends('layouts.store')

@section('content')
<div class="container" style="max-width: 800px; margin: 0 auto; padding: 3rem 1rem;" x-data="{ activeTab: 'order', openIndex: null }">
    <!-- Premium Header -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <span style="background: rgba(27, 42, 71, 0.08); color: var(--color-navy); font-size: 0.9rem; font-weight: 600; padding: 6px 16px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px;">Help Center</span>
        <h1 style="font-size: 2.5rem; font-weight: 700; color: var(--color-navy-dark); margin: 10px 0 15px; font-family: 'Prompt', sans-serif;">ศูนย์ช่วยเหลือและคำถามที่พบบ่อย (FAQ)</h1>
        <p style="color: var(--color-grey); max-width: 600px; margin: 0 auto; font-size: 1.05rem; line-height: 1.6;">ค้นหาคำตอบสำหรับข้อสงสัยเกี่ยวกับการสั่งซื้อ การชำระเงิน การจัดส่ง และเงื่อนไขการรับประกันสินค้าของ dd.it.com</p>
    </div>

    <!-- Tabs Navigation -->
    <div class="mobile-tabs-scroll" style="display: flex; border-bottom: 2px solid var(--color-silver); margin-bottom: 2rem; justify-content: center; gap: 10px;">
        <button type="button" @click="activeTab = 'order'; openIndex = null" style="padding: 12px 20px; font-weight: 600; font-size: 1rem; border: none; background: none; cursor: pointer; transition: all 0.2s; font-family: inherit;" :style="activeTab === 'order' ? 'color: var(--color-navy); border-bottom: 3px solid var(--color-navy); margin-bottom: -2px;' : 'color: var(--color-grey);'">🛒 การสั่งซื้อ</button>
        <button type="button" @click="activeTab = 'shipping'; openIndex = null" style="padding: 12px 20px; font-weight: 600; font-size: 1rem; border: none; background: none; cursor: pointer; transition: all 0.2s; font-family: inherit;" :style="activeTab === 'shipping' ? 'color: var(--color-navy); border-bottom: 3px solid var(--color-navy); margin-bottom: -2px;' : 'color: var(--color-grey);'">🚚 การจัดส่ง</button>
        <button type="button" @click="activeTab = 'returns'; openIndex = null" style="padding: 12px 20px; font-weight: 600; font-size: 1rem; border: none; background: none; cursor: pointer; transition: all 0.2s; font-family: inherit;" :style="activeTab === 'returns' ? 'color: var(--color-navy); border-bottom: 3px solid var(--color-navy); margin-bottom: -2px;' : 'color: var(--color-grey);'">↩️ คืนสินค้า</button>
        <button type="button" @click="activeTab = 'warranty'; openIndex = null" style="padding: 12px 20px; font-weight: 600; font-size: 1rem; border: none; background: none; cursor: pointer; transition: all 0.2s; font-family: inherit;" :style="activeTab === 'warranty' ? 'color: var(--color-navy); border-bottom: 3px solid var(--color-navy); margin-bottom: -2px;' : 'color: var(--color-grey);'">🛡️ การรับประกัน</button>
    </div>

    <!-- Tab Contents (Accordions) -->
    
    <!-- Order FAQ -->
    <div x-show="activeTab === 'order'" style="display: flex; flex-direction: column; gap: 12px;">
        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 8px; overflow: hidden;">
            <button @click="openIndex = openIndex === 0 ? null : 0" style="width: 100%; text-align: left; padding: 18px; font-weight: 600; font-size: 1.05rem; border: none; background: none; cursor: pointer; display: flex; justify-content: space-between; align-items: center; color: var(--color-navy-dark); font-family: inherit;">
                <span>สั่งซื้อสินค้าทางหน้าเว็บได้อย่างไร?</span>
                <span x-text="openIndex === 0 ? '▲' : '▼'" style="font-size: 0.8rem; color: var(--color-grey);">▼</span>
            </button>
            <div x-show="openIndex === 0" x-collapse style="padding: 0 18px 18px; color: var(--color-grey); font-size: 0.95rem; line-height: 1.6; border-top: 1px solid var(--color-grey-bg); padding-top: 15px;">
                คุณสามารถทำตามขั้นตอนง่ายๆ ดังนี้:
                1. สมัครสมาชิกและเข้าสู่ระบบ
                2. เลือกสินค้าที่ต้องการแล้วกด "เพิ่มลงตะกร้า"
                3. ไปที่หน้าตะกร้าสินค้า ตรวจสอบรายการ แล้วกดสั่งซื้อ
                4. กรอกที่อยู่จัดส่ง เลือกช่องทางชำระเงิน และกดยืนยันการสั่งซื้อ
            </div>
        </div>
        
        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 8px; overflow: hidden;">
            <button @click="openIndex = openIndex === 1 ? null : 1" style="width: 100%; text-align: left; padding: 18px; font-weight: 600; font-size: 1.05rem; border: none; background: none; cursor: pointer; display: flex; justify-content: space-between; align-items: center; color: var(--color-navy-dark); font-family: inherit;">
                <span>มีช่องทางการชำระเงินแบบใดบ้าง?</span>
                <span x-text="openIndex === 1 ? '▲' : '▼'" style="font-size: 0.8rem; color: var(--color-grey);">▼</span>
            </button>
            <div x-show="openIndex === 1" x-collapse style="padding: 0 18px 18px; color: var(--color-grey); font-size: 0.95rem; line-height: 1.6; border-top: 1px solid var(--color-grey-bg); padding-top: 15px;">
                เรามีช่องทางชำระเงินที่หลากหลาย ได้แก่:
                - ชำระเงินโอนผ่านธนาคาร หรือ QR Code PromptPay (อัปโหลดสลิปธนาคาร)
                - ชำระเงินออนไลน์และผ่อนชำระผ่านบัตรเครดิต (GB Prime Pay, 2C2P, Pay Solutions)
                - ชำระเงินผ่านแอพพลิเคชั่นธนาคาร K-Plus หรือ PayPal
            </div>
        </div>
    </div>

    <!-- Shipping FAQ -->
    <div x-show="activeTab === 'shipping'" style="display: flex; flex-direction: column; gap: 12px;">
        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 8px; overflow: hidden;">
            <button @click="openIndex = openIndex === 0 ? null : 0" style="width: 100%; text-align: left; padding: 18px; font-weight: 600; font-size: 1.05rem; border: none; background: none; cursor: pointer; display: flex; justify-content: space-between; align-items: center; color: var(--color-navy-dark); font-family: inherit;">
                <span>ใช้เวลาจัดส่งสินค้านานแค่ไหน?</span>
                <span x-text="openIndex === 0 ? '▲' : '▼'" style="font-size: 0.8rem; color: var(--color-grey);">▼</span>
            </button>
            <div x-show="openIndex === 0" x-collapse style="padding: 0 18px 18px; color: var(--color-grey); font-size: 0.95rem; line-height: 1.6; border-top: 1px solid var(--color-grey-bg); padding-top: 15px;">
                สำหรับการจัดส่งในเขตกรุงเทพฯ และปริมณฑล จะใช้เวลาประมาณ 1-2 วันทำการ
                สำหรับต่างจังหวัด จะใช้เวลาประมาณ 2-3 วันทำการ โดยขนส่งเอกชนชั้นนำ (Kerry, Flash Express, J&T)
            </div>
        </div>

        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 8px; overflow: hidden;">
            <button @click="openIndex = openIndex === 1 ? null : 1" style="width: 100%; text-align: left; padding: 18px; font-weight: 600; font-size: 1.05rem; border: none; background: none; cursor: pointer; display: flex; justify-content: space-between; align-items: center; color: var(--color-navy-dark); font-family: inherit;">
                <span>มีค่าบริการจัดส่งสินค้าอย่างไร?</span>
                <span x-text="openIndex === 1 ? '▲' : '▼'" style="font-size: 0.8rem; color: var(--color-grey);">▼</span>
            </button>
            <div x-show="openIndex === 1" x-collapse style="padding: 0 18px 18px; color: var(--color-grey); font-size: 0.95rem; line-height: 1.6; border-top: 1px solid var(--color-grey-bg); padding-top: 15px;">
                เรามีบริการจัดส่งฟรีทั่วประเทศ เมื่อสั่งซื้อสินค้าตั้งแต่ ฿2,000 ขึ้นไป
                หากยอดสั่งซื้อต่ำกว่า ฿2,000 จะคิดค่าจัดส่งแบบเหมาจ่าย ฿50 ทั่วประเทศ
            </div>
        </div>
    </div>

    <!-- Returns FAQ -->
    <div x-show="activeTab === 'returns'" style="display: flex; flex-direction: column; gap: 12px;">
        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 8px; overflow: hidden;">
            <button @click="openIndex = openIndex === 0 ? null : 0" style="width: 100%; text-align: left; padding: 18px; font-weight: 600; font-size: 1.05rem; border: none; background: none; cursor: pointer; display: flex; justify-content: space-between; align-items: center; color: var(--color-navy-dark); font-family: inherit;">
                <span>เงื่อนไขการเปลี่ยน/คืนสินค้าเป็นอย่างไร?</span>
                <span x-text="openIndex === 0 ? '▲' : '▼'" style="font-size: 0.8rem; color: var(--color-grey);">▼</span>
            </button>
            <div x-show="openIndex === 0" x-collapse style="padding: 0 18px 18px; color: var(--color-grey); font-size: 0.95rem; line-height: 1.6; border-top: 1px solid var(--color-grey-bg); padding-top: 15px;">
                คุณสามารถขอเปลี่ยนหรือคืนสินค้าได้ภายใน 7 วัน นับจากวันที่ได้รับสินค้า
                โดยสินค้าจะต้องอยู่ในสภาพสมบูรณ์ ยังไม่ได้แกะซีลพลาสติก กล่องไม่บุบเสียหาย และอุปกรณ์ในกล่องครบถ้วน
            </div>
        </div>
    </div>

    <!-- Warranty FAQ -->
    <div x-show="activeTab === 'warranty'" style="display: flex; flex-direction: column; gap: 12px;">
        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 8px; overflow: hidden;">
            <button @click="openIndex = openIndex === 0 ? null : 0" style="width: 100%; text-align: left; padding: 18px; font-weight: 600; font-size: 1.05rem; border: none; background: none; cursor: pointer; display: flex; justify-content: space-between; align-items: center; color: var(--color-navy-dark); font-family: inherit;">
                <span>สินค้ามีการรับประกันจากศูนย์บริการอย่างไร?</span>
                <span x-text="openIndex === 0 ? '▲' : '▼'" style="font-size: 0.8rem; color: var(--color-grey);">▼</span>
            </button>
            <div x-show="openIndex === 0" x-collapse style="padding: 0 18px 18px; color: var(--color-grey); font-size: 0.95rem; line-height: 1.6; border-top: 1px solid var(--color-grey-bg); padding-top: 15px;">
                สินค้าแบรนด์ Apple ทั้งหมดที่จำหน่ายในร้านของเรา เป็นสินค้าเครื่องศูนย์แท้ รับประกันคุณภาพศูนย์บริการไทย (Apple Authorised Service Provider / iCare) เป็นเวลา 1 ปีเต็มตามมาตรฐานสากล
            </div>
        </div>

        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 8px; overflow: hidden;">
            <button @click="openIndex = openIndex === 1 ? null : 1" style="width: 100%; text-align: left; padding: 18px; font-weight: 600; font-size: 1.05rem; border: none; background: none; cursor: pointer; display: flex; justify-content: space-between; align-items: center; color: var(--color-navy-dark); font-family: inherit;">
                <span>จะส่งเคลมสินค้าหรือแจ้งซ่อมได้อย่างไร?</span>
                <span x-text="openIndex === 1 ? '▲' : '▼'" style="font-size: 0.8rem; color: var(--color-grey);">▼</span>
            </button>
            <div x-show="openIndex === 1" x-collapse style="padding: 0 18px 18px; color: var(--color-grey); font-size: 0.95rem; line-height: 1.6; border-top: 1px solid var(--color-grey-bg); padding-top: 15px;">
                ท่านสามารถนำสินค้าเข้าศูนย์บริการ iCare หรือศูนย์ซ่อม Apple อย่างเป็นทางการได้ทุกสาขา
                หรือท่านสามารถส่งเคลมกับทางร้านได้ง่ายๆ โดยการกรอกข้อมูลและทำเรื่องแจ้งเคลมได้ที่หน้า <a href="{{ route('service_center') }}" style="color: var(--color-navy); font-weight: 600;">ศูนย์บริการ (Service Center)</a> ของทางเรา ซึ่งหลังบ้านของเราจะมีระบบอัปเดตและติดตามงานเคลมให้อย่างเป็นระเบียบเรียบร้อยครับ
            </div>
        </div>
    </div>

</div>
@endsection
