@extends('layouts.store')

@section('content')
<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;" x-data="{ 
    cart: {{ json_encode(session('cart', [])) }},
    selectedItems: Object.keys({{ json_encode(session('cart', [])) }}),
    updateQuantity(id, qty) {
        if(qty < 1) qty = 1;
        fetch('{{ route('cart.update') }}', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: id, quantity: qty })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                this.cart[id].quantity = qty;
            }
        });
    },
    removeItem(id) {
        Swal.fire({
            title: 'ต้องการลบสินค้านี้?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--color-navy)',
            cancelButtonColor: 'var(--color-danger)',
            confirmButtonText: 'ใช่, ลบเลย',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('{{ route('cart.remove') }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        delete this.cart[id];
                        this.selectedItems = this.selectedItems.filter(item => item !== id);
                        Swal.fire({
                            title: 'ลบเรียบร้อยแล้ว!',
                            icon: 'success',
                            confirmButtonColor: 'var(--color-navy)'
                        });
                    }
                });
            }
        });
    },
    get total() {
        return Object.entries(this.cart).reduce((sum, [id, item]) => {
            if (this.selectedItems.includes(id)) {
                return sum + (item.price * item.quantity);
            }
            return sum;
        }, 0);
    }
}">
    <h2 style="font-size: 2rem; color: var(--color-navy-dark); margin-bottom: 2rem; font-weight: 700;">ตะกร้าสินค้าของคุณ</h2>

    <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
        <!-- Cart Items List -->
        <div style="flex: 2 1 600px;">
            <template x-if="Object.keys(cart).length === 0">
                <div style="background: white; padding: 3rem; text-align: center; border-radius: 12px; border: 1px solid var(--color-silver);">
                    <p style="font-size: 1.2rem; color: var(--color-grey); margin-bottom: 1.5rem;">ไม่มีสินค้าในตะกร้า</p>
                    <a href="{{ route('products.index') }}" style="display: inline-block; padding: 12px 30px; background: var(--color-navy); color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">เลือกซื้อสินค้า</a>
                </div>
            </template>

            <template x-if="Object.keys(cart).length > 0">
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <template x-for="(item, id) in cart" :key="id">
                        <div style="background: white; border: 1px solid var(--color-silver); border-radius: 12px; padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; flex-wrap: wrap; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                            <!-- Selection Checkbox -->
                            <div style="display: flex; align-items: center; padding-right: 5px;">
                                <input type="checkbox" :value="id" x-model="selectedItems" style="width: 20px; height: 20px; cursor: pointer; accent-color: var(--color-navy);">
                            </div>

                            <!-- Product Image -->
                            <div style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; background: var(--color-grey-bg); border-radius: 8px;">
                                <template x-if="item.image">
                                    <img :src="item.image.startsWith('http') ? item.image : '/storage/' + item.image" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                </template>
                                <template x-if="!item.image">
                                    <span style="font-size: 2rem; color: var(--color-grey-light);">📱</span>
                                </template>
                            </div>

                            <!-- Product Info -->
                            <div style="flex: 1 1 200px;">
                                <h3 style="font-size: 1.1rem; font-weight: 600; color: var(--color-navy-dark); margin: 0 0 0.5rem;" x-text="item.name"></h3>
                                <p style="font-size: 1.15rem; font-weight: 700; color: var(--color-accent); margin: 0;">฿<span x-text="Number(item.price).toLocaleString()"></span></p>
                            </div>

                            <!-- Quantity Controller -->
                            <div style="display: flex; align-items: center; gap: 5px; border: 1px solid var(--color-silver); border-radius: 20px; overflow: hidden; background: var(--color-grey-bg);">
                                <button @click="updateQuantity(id, item.quantity - 1)" style="border: none; background: none; width: 32px; height: 32px; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">-</button>
                                <span style="font-weight: 600; width: 30px; text-align: center; font-size: 1rem;" x-text="item.quantity"></span>
                                <button @click="updateQuantity(id, item.quantity + 1)" style="border: none; background: none; width: 32px; height: 32px; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">+</button>
                            </div>

                            <!-- Action -->
                            <div style="text-align: right;">
                                <button @click="removeItem(id)" style="background: none; border: none; color: var(--color-danger); cursor: pointer; font-weight: 600; font-size: 0.95rem;">ลบ</button>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <!-- Cart Summary / Order Checkout Card -->
        <template x-if="Object.keys(cart).length > 0">
            <div style="flex: 1 1 350px;">
                <div style="background: white; border: 1px solid var(--color-silver); border-radius: 12px; padding: 2rem; box-shadow: 0 10px 20px rgba(0,0,0,0.05); position: sticky; top: 100px;">
                    <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-navy-dark); margin-bottom: 1.5rem; border-bottom: 2px solid var(--color-silver); padding-bottom: 0.5rem;">สรุปคำสั่งซื้อ</h3>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; font-size: 1.05rem;">
                        <span style="color: var(--color-grey);">ยอดรวมสินค้า</span>
                        <span style="font-weight: 600; color: var(--color-navy-dark);">฿<span x-text="total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span></span>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; font-size: 1.05rem;">
                        <span style="color: var(--color-grey);">ค่าจัดส่ง</span>
                        <span style="font-weight: 600; color: var(--color-success);">ฟรี</span>
                    </div>

                    <hr style="border: 0; border-top: 1px solid var(--color-silver); margin-bottom: 1.5rem;">

                    <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; font-size: 1.25rem; font-weight: 700;">
                        <span style="color: var(--color-navy-dark);">ยอดชำระสุทธิ</span>
                        <span style="color: var(--color-accent);">฿<span x-text="total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span></span>
                    </div>

                    <a :href="selectedItems.length ? '{{ route('checkout.index') }}?items=' + selectedItems.join(',') : '#'"
                       @click="if(!selectedItems.length) { $event.preventDefault(); Swal.fire({icon: 'warning', title: 'กรุณาเลือกสินค้า', text: 'กรุณาเลือกสินค้าอย่างน้อย 1 ชิ้นเพื่อดำเนินชำระเงิน'}); }"
                       style="display: block; width: 100%; text-align: center; padding: 14px; background: linear-gradient(135deg, var(--color-navy) 0%, var(--color-navy-light) 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 1.1rem; box-shadow: 0 4px 15px rgba(27,42,71,0.25); transition: transform 0.2s;" 
                       onmouseover="this.style.transform='translateY(-1px)'" 
                       onmouseout="this.style.transform='translateY(0)'">ไปชำระเงิน</a>


                </div>
            </div>
        </template>
    </div>
</div>
@endsection
