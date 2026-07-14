@extends('layouts.store')

@section('content')
<div class="container" style="max-width: 1000px; margin: 0 auto; padding: 3rem 1rem;" x-data="{
    price: 32900,
    bank: 'kbank_0',
    months: 10,
    customPrice: '',
    get monthlyPayment() {
        let p = parseFloat(this.price) || 0;
        let rate = 0;
        if (this.bank === 'scb_interest') {
            rate = 0.0099; // 0.99% per month
        } else if (this.bank === 'krungsri_interest') {
            rate = 0.0079; // 0.79% per month
        }
        
        if (rate > 0) {
            let totalInterest = p * rate * this.months;
            return ((p + totalInterest) / this.months).toFixed(2);
        } else {
            return (p / this.months).toFixed(2);
        }
    },
    get totalPaid() {
        return (parseFloat(this.monthlyPayment) * this.months).toFixed(2);
    },
    get totalInterest() {
        return (parseFloat(this.totalPaid) - (parseFloat(this.price) || 0)).toFixed(2);
    },
    updatePrice(val) {
        this.price = val;
        this.customPrice = '';
    },
    updateCustomPrice() {
        let val = parseFloat(this.customPrice);
        if (!isNaN(val) && val > 0) {
            this.price = val;
        }
    }
}">
    <!-- Premium Header -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <span style="background: rgba(27, 42, 71, 0.08); color: var(--color-navy); font-size: 0.9rem; font-weight: 600; padding: 6px 16px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px;">Installment Options</span>
        <h1 style="font-size: 2.5rem; font-weight: 700; color: var(--color-navy-dark); margin: 10px 0 15px; font-family: 'Prompt', sans-serif;">บริการผ่อนชำระค่างวด</h1>
        <p style="color: var(--color-grey); max-width: 600px; margin: 0 auto; font-size: 1.05rem; line-height: 1.6;">เลือกผ่อนชำระผ่านบัตรเครดิตธนาคารชั้นนำ ดอกเบี้ย 0% นานสูงสุด 10 เดือน หรือผ่อนแบบใช้เอกสารไม่ต้องใช้บัตรเครดิต</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: start; margin-bottom: 4rem;">
        
        <!-- Calculator Section -->
        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 16px; padding: 2.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
            <h3 style="font-size: 1.4rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                🧮 เครื่องคำนวณค่างวดรายเดือน
            </h3>
            
            <!-- Quick Prices -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-navy-dark);">เลือกราคาสินค้าเริ่มต้น</label>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                    <button type="button" @click="updatePrice(19900)" style="padding: 10px; border-radius: 8px; border: 1px solid var(--color-silver); background: var(--color-grey-bg); cursor: pointer; font-weight: 600; transition: all 0.2s;" :style="price == 19900 ? 'border-color: var(--color-navy); background: var(--color-navy); color: white;' : ''">฿19,900</button>
                    <button type="button" @click="updatePrice(32900)" style="padding: 10px; border-radius: 8px; border: 1px solid var(--color-silver); background: var(--color-grey-bg); cursor: pointer; font-weight: 600; transition: all 0.2s;" :style="price == 32900 ? 'border-color: var(--color-navy); background: var(--color-navy); color: white;' : ''">฿32,900</button>
                    <button type="button" @click="updatePrice(44900)" style="padding: 10px; border-radius: 8px; border: 1px solid var(--color-silver); background: var(--color-grey-bg); cursor: pointer; font-weight: 600; transition: all 0.2s;" :style="price == 44900 ? 'border-color: var(--color-navy); background: var(--color-navy); color: white;' : ''">฿44,900</button>
                </div>
            </div>

            <!-- Custom Price Input -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-navy-dark);">หรือ ระบุราคาสินค้าเอง (บาท)</label>
                <input type="number" x-model="customPrice" @input="updateCustomPrice()" placeholder="ระบุจำนวนเงิน..." style="width: 100%; padding: 12px; border: 1px solid var(--color-silver); border-radius: 8px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--color-navy)'" onblur="this.style.borderColor='var(--color-silver)'">
            </div>

            <!-- Bank / Plan Selection -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-navy-dark);">เลือกธนาคารและแผนการผ่อน</label>
                <select x-model="bank" @change="months = 10" style="width: 100%; padding: 12px; border: 1px solid var(--color-silver); border-radius: 8px; font-family: inherit; font-size: 0.95rem;">
                    <option value="kbank_0">ธนาคารกสิกรไทย (0% ดอกเบี้ย)</option>
                    <option value="scb_0">ธนาคารไทยพาณิชย์ (0% ดอกเบี้ย)</option>
                    <option value="scb_interest">ธนาคารไทยพาณิชย์ (ดอกเบี้ยพิเศษ 0.99%/เดือน)</option>
                    <option value="krungsri_0">ธนาคารกรุงศรีฯ (0% ดอกเบี้ย)</option>
                    <option value="krungsri_interest">ธนาคารกรุงศรีฯ (ดอกเบี้ยพิเศษ 0.79%/เดือน)</option>
                </select>
            </div>

            <!-- Tenure (Months) -->
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-navy-dark);">จำนวนเดือนที่ต้องการผ่อน</label>
                <div style="display: flex; gap: 10px;">
                    <template x-if="bank.includes('_0')">
                        <div style="display: flex; gap: 10px; width: 100%;">
                            <button type="button" @click="months = 3" style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid var(--color-silver); background: var(--color-grey-bg); cursor: pointer; font-weight: 600; transition: all 0.2s;" :style="months == 3 ? 'border-color: var(--color-navy); background: var(--color-navy); color: white;' : ''">3 เดือน</button>
                            <button type="button" @click="months = 6" style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid var(--color-silver); background: var(--color-grey-bg); cursor: pointer; font-weight: 600; transition: all 0.2s;" :style="months == 6 ? 'border-color: var(--color-navy); background: var(--color-navy); color: white;' : ''">6 เดือน</button>
                            <button type="button" @click="months = 10" style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid var(--color-silver); background: var(--color-grey-bg); cursor: pointer; font-weight: 600; transition: all 0.2s;" :style="months == 10 ? 'border-color: var(--color-navy); background: var(--color-navy); color: white;' : ''">10 เดือน</button>
                        </div>
                    </template>
                    <template x-if="!bank.includes('_0')">
                        <div style="display: flex; gap: 10px; width: 100%;">
                            <button type="button" @click="months = 12" style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid var(--color-silver); background: var(--color-grey-bg); cursor: pointer; font-weight: 600; transition: all 0.2s;" :style="months == 12 ? 'border-color: var(--color-navy); background: var(--color-navy); color: white;' : ''">12 เดือน</button>
                            <button type="button" @click="months = 18" style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid var(--color-silver); background: var(--color-grey-bg); cursor: pointer; font-weight: 600; transition: all 0.2s;" :style="months == 18 ? 'border-color: var(--color-navy); background: var(--color-navy); color: white;' : ''">18 เดือน</button>
                            <button type="button" @click="months = 24" style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid var(--color-silver); background: var(--color-grey-bg); cursor: pointer; font-weight: 600; transition: all 0.2s;" :style="months == 24 ? 'border-color: var(--color-navy); background: var(--color-navy); color: white;' : ''">24 เดือน</button>
                        </div>
                    </template>
                </div>
            </div>

        </div>

        <!-- Result Box -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            
            <div style="background: linear-gradient(135deg, var(--color-navy-dark) 0%, var(--color-navy) 100%); color: white; border-radius: 16px; padding: 2.5rem; box-shadow: 0 10px 30px rgba(27,42,71,0.15);">
                <span style="font-size: 0.9rem; text-transform: uppercase; color: var(--color-silver); font-weight: 600; letter-spacing: 1px;">ประมาณการชำระเงิน</span>
                
                <div style="margin-top: 15px; margin-bottom: 25px;">
                    <span style="font-size: 3rem; font-weight: 700; color: #FFD700; line-height: 1;" x-text="'฿' + parseFloat(monthlyPayment).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})">฿0.00</span>
                    <span style="font-size: 1.1rem; color: var(--color-silver);"> / เดือน</span>
                </div>

                <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.5rem; display: flex; flex-direction: column; gap: 10px; font-size: 0.95rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--color-silver);">ราคาสินค้าทั้งหมด:</span>
                        <strong style="font-size: 1.05rem;" x-text="'฿' + parseFloat(price).toLocaleString()">฿0</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--color-silver);">ระยะเวลาผ่อน:</span>
                        <strong style="font-size: 1.05rem;" x-text="months + ' เดือน'">0 เดือน</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--color-silver);">ดอกเบี้ยรวม:</span>
                        <strong style="font-size: 1.05rem; color: #4ade80;" x-text="'฿' + parseFloat(totalInterest).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})">฿0.00</strong>
                    </div>
                    <div style="display: flex; justify-content: justify; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px; justify-content: space-between; font-weight: 700;">
                        <span>ยอดชำระสุทธิ:</span>
                        <span style="font-size: 1.2rem; color: #FFD700;" x-text="'฿' + parseFloat(totalPaid).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})">฿0.00</span>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <a href="https://line.me/ti/p/@dditcom" target="_blank" style="background: #06c755; color: white; text-align: center; padding: 16px; border-radius: 12px; font-weight: 700; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 4px 15px rgba(6,199,85,0.25); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fa-brands fa-line" style="font-size: 1.5rem;"></i> ติดต่อแอดมิน เพื่อทำรายการผ่อนชำระ
            </a>

        </div>

    </div>

    <!-- Conditions and Info -->
    <div style="background: var(--color-grey-bg); border-radius: 16px; padding: 2.5rem;">
        <h3 style="font-size: 1.4rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 2rem; border-bottom: 2px solid var(--color-silver); padding-bottom: 0.75rem;">🧾 เงื่อนไขและเอกสารที่ต้องใช้</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div>
                <h4 style="color: var(--color-navy); font-weight: 700; font-size: 1.1rem; margin-bottom: 10px;">💳 ผ่อนชำระผ่านบัตรเครดิต</h4>
                <ul style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7; padding-left: 20px; display: flex; flex-direction: column; gap: 8px;">
                    <li>รับผ่อนชำระผ่านบัตรเครดิตธนาคาร KBank, SCB, Krungsri, UOB, Citibank, BBL</li>
                    <li>วงเงินบัตรเครดิตจะต้องเพียงพอกับราคาสินค้าในวันที่ชำระเงิน</li>
                    <li>สามารถกดยืนยันการผ่อนชำระตามขั้นตอนการสั่งซื้อหน้าตะกร้าสินค้าได้ทันที</li>
                </ul>
            </div>
            <div>
                <h4 style="color: var(--color-navy); font-weight: 700; font-size: 1.1rem; margin-bottom: 10px;">📄 ผ่อนชำระไม่ใช้บัตร (สำหรับนักศึกษา/บุคคลทั่วไป)</h4>
                <ul style="color: var(--color-grey); font-size: 0.95rem; line-height: 1.7; padding-left: 20px; display: flex; flex-direction: column; gap: 8px;">
                    <li>บัตรประจำตัวประชาชนตัวจริง (ต้องมีอายุ 18 ปีขึ้นไป)</li>
                    <li>เอกสารแสดงรายได้ เช่นสลิปเงินเดือน หรือรายการเดินบัญชีย้อนหลัง 6 เดือน</li>
                    <li>สำหรับนักศึกษา: บัตรนักศึกษา และใบลงทะเบียนเรียนเทอมล่าสุด</li>
                    <li>ติดต่อแอดมินผ่าน LINE OA เพื่อกรอกข้อมูลพิจารณาและอนุมัติวงเงินภายใน 30 นาที</li>
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection
