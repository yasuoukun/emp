@extends('layouts.store')

@section('content')
<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;" x-data="{ 
    selectedAddress: '{{ $mainAddress ? $mainAddress->address_line . ", " . $mainAddress->subdistrict . ", " . $mainAddress->district . ", " . $mainAddress->province . " " . $mainAddress->postal_code . " (โทร: " . $mainAddress->phone . ")" : "" }}',
    paymentMethod: 'promptpay',
    setAddress(addrText) {
        this.selectedAddress = addrText;
    }
}">
    <h2 style="font-size: 2rem; color: var(--color-navy-dark); margin-bottom: 2rem; font-weight: 700;">ทำการสั่งซื้อสินค้า</h2>

    <form action="{{ route('checkout.process') }}" method="POST" style="display: flex; gap: 2rem; flex-wrap: wrap;">
        @csrf
        
        <!-- Left Column: Shipping & Payment -->
        <div style="flex: 2 1 600px; display: flex; flex-direction: column; gap: 1.5rem;">
            
            <!-- Address Selection -->
            <div style="background: white; border: 1px solid var(--color-silver); border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 1.5rem; border-bottom: 2px solid var(--color-silver); padding-bottom: 0.5rem;">ที่อยู่จัดส่ง</h3>
                
                @if($addresses->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">
                    <p style="font-weight: 600; color: var(--color-grey); font-size: 0.95rem; margin: 0;">เลือกจากที่อยู่ที่บันทึกไว้:</p>
                    @foreach($addresses as $addr)
                    <div @click="setAddress('{{ $addr->address_line }}, {{ $addr->subdistrict }}, {{ $addr->district }}, {{ $addr->province }} {{ $addr->postal_code }} (โทร: {{ $addr->phone }})')" 
                         style="border: 1px solid var(--color-silver); padding: 1rem; border-radius: 8px; cursor: pointer; background: var(--color-grey-bg); transition: all 0.2s;"
                         :style="selectedAddress.includes('{{ $addr->address_line }}') ? 'border-color: var(--color-navy); background: rgba(27,42,71,0.02); box-shadow: 0 0 0 2px var(--color-navy);' : ''"
                         onmouseover="this.style.borderColor='var(--color-navy)'"
                         onmouseout="this.style.borderColor='var(--color-silver)'">
                        <p style="margin: 0 0 0.25rem; font-weight: 600; color: var(--color-navy-dark);">
                            {{ $addr->address_line }}
                            @if($addr->is_main)
                            <span style="background: var(--color-navy); color: white; font-size: 0.7rem; padding: 1px 6px; border-radius: 10px; margin-left: 5px;">หลัก</span>
                            @endif
                        </p>
                        <p style="margin: 0; font-size: 0.9rem; color: var(--color-grey);">{{ $addr->subdistrict }}, {{ $addr->district }}, {{ $addr->province }}, {{ $addr->postal_code }}</p>
                    </div>
                    @endforeach
                </div>
                @else
                <div style="background: rgba(49, 130, 206, 0.05); color: var(--color-navy-dark); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px dashed rgba(49, 130, 206, 0.2); font-size: 0.9rem; line-height: 1.5;">
                    💡 คุณยังไม่มีที่อยู่จัดส่งที่บันทึกไว้ในระบบ สามารถพิมพ์ระบุที่อยู่ใหม่ในช่องข้อความด้านล่างนี้ได้ทันที (ระบบจะบันทึกเป็นที่อยู่หลักของคุณให้โดยอัตโนมัติ)
                </div>
                @endif

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-navy-dark);">ที่อยู่สำหรับจัดส่งสินค้า</label>
                    <textarea name="shipping_info" x-model="selectedAddress" rows="4" required placeholder="กรอกรายละเอียดที่อยู่จัดส่งที่นี่..." style="width: 100%; padding: 12px; border: 1px solid var(--color-silver); border-radius: 8px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--color-navy)'" onblur="this.style.borderColor='var(--color-silver)'"></textarea>
                </div>
            </div>

            <!-- Payment Selection -->
            <div style="background: white; border: 1px solid var(--color-silver); border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 1.5rem; border-bottom: 2px solid var(--color-silver); padding-bottom: 0.5rem;">วิธีการชำระเงิน (ระบบจำลอง)</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <label style="border: 1px solid var(--color-silver); padding: 1.25rem; border-radius: 8px; display: flex; align-items: center; gap: 15px; cursor: pointer; transition: all 0.2s;" :style="paymentMethod === 'promptpay' ? 'border-color: var(--color-navy); background: rgba(27,42,71,0.02);' : ''">
                        <input type="radio" name="payment_method" value="promptpay" x-model="paymentMethod">
                        <div>
                            <span style="font-size: 1.5rem;">📱</span>
                            <span style="font-weight: 600; color: var(--color-navy-dark); display: block; margin-top: 5px;">Thai PromptPay (QR)</span>
                        </div>
                    </label>

                    <label style="border: 1px solid var(--color-silver); padding: 1.25rem; border-radius: 8px; display: flex; align-items: center; gap: 15px; cursor: pointer; transition: all 0.2s;" :style="paymentMethod === 'credit_card' ? 'border-color: var(--color-navy); background: rgba(27,42,71,0.02);' : ''">
                        <input type="radio" name="payment_method" value="credit_card" x-model="paymentMethod">
                        <div>
                            <span style="font-size: 1.5rem;">💳</span>
                            <span style="font-weight: 600; color: var(--color-navy-dark); display: block; margin-top: 5px;">Credit Card (Mock)</span>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <!-- Right Column: Cart Summary & Button -->
        <div style="flex: 1 1 350px;">
            <div style="background: white; border: 1px solid var(--color-silver); border-radius: 12px; padding: 2rem; box-shadow: 0 10px 20px rgba(0,0,0,0.05); position: sticky; top: 100px;">
                <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 1.5rem; border-bottom: 2px solid var(--color-silver); padding-bottom: 0.5rem;">รายการสินค้า</h3>
                
                <!-- Hidden inputs for items being processed -->
                @foreach($cart as $id => $item)
                    <input type="hidden" name="items[]" value="{{ $id }}">
                @endforeach

                <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">
                    @php $total = 0; @endphp
                    @foreach($cart as $item)
                    @php $total += $item['price'] * $item['quantity']; @endphp
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.95rem;">
                        <span style="color: var(--color-navy-dark); font-weight: 500;">{{ $item['name'] }} <small style="color: var(--color-grey);">x{{ $item['quantity'] }}</small></span>
                        <span style="font-weight: 600; color: var(--color-navy-dark);">฿{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                    @endforeach
                </div>

                <!-- Coupon Selector Section -->
                <div style="margin: 1.5rem 0; padding-top: 1.5rem; border-top: 1px solid var(--color-silver);">
                    <label style="display: block; font-weight: 700; margin-bottom: 0.75rem; color: var(--color-navy-dark); font-size: 0.95rem;">🎟️ เลือกใช้คูปองส่วนลดที่คุณเก็บไว้</label>
                    
                    @if($collectedCoupons->count() > 0)
                        <div style="display: flex; flex-direction: column; gap: 10px; max-height: 180px; overflow-y: auto; margin-bottom: 1rem; padding-right: 5px;">
                            @foreach($collectedCoupons as $cc)
                                @php
                                    $c = $cc->coupon;
                                    $isApplied = session('coupon') && session('coupon')->id === $c->id;
                                @endphp
                                <div style="border: 1px solid {{ $isApplied ? '#FF4500' : 'var(--color-silver)' }}; padding: 10px; border-radius: 8px; background: {{ $isApplied ? 'rgba(255, 69, 0, 0.03)' : 'white' }}; display: flex; justify-content: space-between; align-items: center; transition: all 0.2s;">
                                    <div style="flex-grow: 1;">
                                        <p style="margin: 0; font-size: 0.85rem; font-weight: 700; color: var(--color-navy-dark);">
                                            {{ $c->name }}
                                        </p>
                                        <div style="display: flex; gap: 8px; margin-top: 2px; align-items: center;">
                                            <span style="background: #FF4500; color: white; font-size: 0.75rem; padding: 1px 6px; border-radius: 4px; font-weight: bold;">
                                                ลด ฿{{ number_format($c->discount_amount, 0) }}
                                            </span>
                                            <code style="font-size: 0.8rem; color: var(--color-grey);">{{ $c->code }}</code>
                                        </div>
                                    </div>
                                    <div>
                                        @if($isApplied)
                                            <span style="color: #FF4500; font-size: 0.85rem; font-weight: bold; display: flex; align-items: center; gap: 4px;">
                                                ✔️ ใช้งานอยู่
                                            </span>
                                        @else
                                            <button type="button" onclick="submitApplyCoupon('{{ $c->code }}')" style="background: var(--color-navy); color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: bold; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='var(--color-navy-light)'" onmouseout="this.style.background='var(--color-navy)'">
                                                ใช้งาน
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="color: var(--color-grey); font-size: 0.85rem; font-style: italic; margin-bottom: 1rem;">
                            คุณไม่มีคูปองส่วนลดที่ใช้ได้สำหรับรายการนี้ (ไปเก็บโค้ดได้ที่เมนู <a href="{{ route('promotions.index') }}" style="color: #FF4500; text-decoration: underline; font-weight: bold;">โปรโมชันพิเศษ</a>)
                        </p>
                    @endif

                    <div style="display: flex; gap: 8px;">
                        <input type="text" id="coupon_code_input" placeholder="หรือพิมพ์รหัสส่วนลด..." value="{{ session('coupon') ? session('coupon')->code : '' }}" style="flex: 1; padding: 8px 12px; border: 1px solid var(--color-silver); border-radius: 6px; font-family: inherit; font-size: 0.9rem; outline: none;">
                        <button type="button" onclick="applyCouponCode()" style="background: var(--color-navy); color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 600; cursor: pointer; font-family: inherit; font-size: 0.9rem;">ใช้งาน</button>
                    </div>
                </div>

                <hr style="border: 0; border-top: 1px solid var(--color-silver); margin-bottom: 1.5rem;">

                @php 
                    $discount = session()->has('coupon') ? session('coupon')->discount_amount : 0;
                    $netTotal = max(0, $total - $discount);
                @endphp

                <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 2rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 1rem;">
                        <span style="color: var(--color-grey);">รวมค่าสินค้า</span>
                        <span style="font-weight: 600; color: var(--color-navy-dark);">฿{{ number_format($total, 2) }}</span>
                    </div>
                    @if($discount > 0)
                    <div style="display: flex; justify-content: space-between; font-size: 1rem; color: var(--color-danger);">
                        <span>ส่วนลดคูปอง</span>
                        <span style="font-weight: 600;">-฿{{ number_format($discount, 2) }}</span>
                    </div>
                    @endif
                    <div style="display: flex; justify-content: space-between; font-size: 1.25rem; font-weight: 700; border-top: 1px solid var(--color-silver-light); padding-top: 10px; margin-top: 5px;">
                        <span style="color: var(--color-navy-dark);">ยอดสุทธิ</span>
                        <span style="color: var(--color-accent);">฿{{ number_format($netTotal, 2) }}</span>
                    </div>
                </div>

                <button type="submit" style="width: 100%; text-align: center; padding: 14px; background: linear-gradient(135deg, var(--color-navy) 0%, var(--color-navy-light) 100%); color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 1.1rem; cursor: pointer; box-shadow: 0 4px 15px rgba(27,42,71,0.25); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">ชำระเงินและสั่งซื้อ</button>
            </div>
        </div>

    </form>
</div>

<!-- Hidden coupon submission form -->
<form id="coupon-form" action="{{ route('coupons.apply') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="coupon_code" id="hidden_coupon_code">
</form>

<script>
    function submitApplyCoupon(code) {
        document.getElementById('hidden_coupon_code').value = code;
        document.getElementById('coupon-form').submit();
    }

    function applyCouponCode() {
        const val = document.getElementById('coupon_code_input').value.trim();
        if (!val) {
            Swal.fire({
                icon: 'warning',
                title: 'กรุณากรอกรหัสคูปอง',
                confirmButtonColor: '#1B2A47'
            });
            return;
        }
        submitApplyCoupon(val);
    }
</script>
@endsection
