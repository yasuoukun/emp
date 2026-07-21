@extends('layouts.store')

@section('content')
<div class="container fade-in" style="padding: 2.5rem 1rem; display: flex; gap: 2.5rem; flex-wrap: wrap;">

    <!-- Left Sidebar: Filters -->
    <aside style="flex: 1 1 280px; background: white; padding: 2rem; border-radius: 20px; border: 1px solid rgba(226, 232, 240, 0.8); height: fit-content; box-shadow: 0 4px 15px rgba(27, 42, 71, 0.02);">
        <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--color-navy-dark); margin-bottom: 1.5rem; border-bottom: 2px solid rgba(226, 232, 240, 0.6); padding-bottom: 0.75rem; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-sliders text-indigo-600"></i> ตัวกรองสินค้า
        </h3>
        
        <form action="{{ route('products.index') }}" method="GET" style="display: flex; flex-direction: column; gap: 1.5rem;">
            
            <!-- Search Keyword Input -->
            <div>
                <h4 style="font-weight: 700; color: var(--color-navy); margin-bottom: 0.6rem; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.05em;">ค้นหาชื่อสินค้า</h4>
                <div style="position: relative;">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="พิมพ์ชื่อสินค้า..." 
                           style="width: 100%; padding: 10px 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; font-family: inherit; outline: none; transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--color-navy)'"
                           onblur="this.style.borderColor='#e2e8f0'">
                </div>
            </div>

            <!-- Brand Filter (Checkboxes) -->
            <div>
                <h4 style="font-weight: 700; color: var(--color-navy); margin-bottom: 0.6rem; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.05em;">แบรนด์ / ยี่ห้อ</h4>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    @foreach($brands as $brand)
                    @php
                        $brandChecked = is_array(request('brand_ids')) && in_array($brand->id, request('brand_ids')) || request('brand_id') == $brand->id;
                    @endphp
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem; color: #475569; transition: color 0.2s;" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color='#475569'">
                        <input type="checkbox" name="brand_ids[]" value="{{ $brand->id }}" {{ $brandChecked ? 'checked' : '' }} 
                               style="width: 16px; height: 16px; border: 1.5px solid #cbd5e1; border-radius: 4px; cursor: pointer; accent-color: var(--color-navy);">
                        <span>{{ $brand->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Category Filter (Checkboxes) -->
            <div>
                <h4 style="font-weight: 700; color: var(--color-navy); margin-bottom: 0.6rem; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.05em;">หมวดหมู่สินค้า</h4>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    @foreach($categories as $category)
                    @php
                        $catChecked = is_array(request('category_ids')) && in_array($category->id, request('category_ids')) || request('category_id') == $category->id;
                    @endphp
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem; color: #475569; transition: color 0.2s;" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color='#475569'">
                        <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" {{ $catChecked ? 'checked' : '' }} 
                               style="width: 16px; height: 16px; border: 1.5px solid #cbd5e1; border-radius: 4px; cursor: pointer; accent-color: var(--color-navy);">
                        <span>{{ $category->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Price Range Filter -->
            <div>
                <h4 style="font-weight: 700; color: var(--color-navy); margin-bottom: 0.6rem; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.05em;">ช่วงราคา (บาท)</h4>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="ต่ำสุด" min="0"
                           style="width: 100%; padding: 8px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; outline: none; transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--color-navy)'" onblur="this.style.borderColor='#e2e8f0'">
                    <span style="color: #94a3b8;">-</span>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="สูงสุด" min="0"
                           style="width: 100%; padding: 8px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem; outline: none; transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--color-navy)'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
            </div>

            <!-- Special Discount Filter Toggle -->
            <div>
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.95rem; font-weight: 700; color: var(--color-navy-dark);">
                    <input type="checkbox" name="on_sale" value="1" {{ request('on_sale') == '1' ? 'checked' : '' }}
                           style="width: 18px; height: 18px; border: 1.5px solid #cbd5e1; border-radius: 4px; cursor: pointer; accent-color: #ef4444;">
                    <span style="color: #ef4444; display: flex; align-items: center; gap: 4px;">
                        🔥 สินค้าลดราคาพิเศษ
                    </span>
                </label>
            </div>

            <!-- Filter Buttons -->
            <div style="display: flex; flex-direction: column; gap: 8px; margin-top: 0.5rem;">
                <button type="submit" style="width: 100%; padding: 12px; background: var(--color-navy); color: white; border: none; border-radius: 12px; cursor: pointer; font-weight: 700; transition: all 0.2s; box-shadow: 0 4px 10px rgba(27, 42, 71, 0.15);" onmouseover="this.style.background='var(--color-navy-light)'" onmouseout="this.style.background='var(--color-navy)'">
                    ค้นหาและกรองข้อมูล
                </button>
                <a href="{{ route('products.index') }}" style="display: block; text-align: center; padding: 10px; color: var(--color-danger); text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: color 0.2s; border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 12px;" onmouseover="this.style.background='rgba(239, 68, 68, 0.05)'" onmouseout="this.style.background='transparent'">
                    ล้างตัวกรองทั้งหมด
                </a>
            </div>

        </form>
    </aside>

    <!-- Main Content: Products Grid -->
    <main style="flex: 3 1 600px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem;">
            <h2 style="font-size: 1.75rem; font-weight: 800; color: var(--color-navy-dark); margin: 0; letter-spacing: -0.02em;">สินค้าทั้งหมด</h2>
            <span style="font-size: 0.9rem; color: #64748b; font-weight: 500;">พบสินค้าทั้งหมด {{ $products->total() }} รายการ</span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 24px; margin-bottom: 3rem;">
            @forelse($products as $product)
            <div class="hover-scale" style="background: white; border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 15px rgba(27, 42, 71, 0.03);">
                <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; color: inherit; display: block; padding: 1.5rem; text-align: center; position: relative;">
                    <!-- Stock Pill -->
                    @if($product->stock <= 0)
                        <span style="position: absolute; top: 12px; right: 12px; font-size: 10px; font-weight: bold; background: #ef4444; color: white; padding: 4px 8px; border-radius: 99px;">สินค้าหมด</span>
                    @elseif($product->stock <= 5)
                        <span style="position: absolute; top: 12px; right: 12px; font-size: 10px; font-weight: bold; background: #f59e0b; color: white; padding: 4px 8px; border-radius: 99px;">ใกล้หมดเหลือ {{ $product->stock }} ชิ้น</span>
                    @endif

                    @if($product->images->where('is_primary', true)->first())
                        @php
                            $imgPath = $product->images->where('is_primary', true)->first()->image_path;
                        @endphp
                        @if(str_starts_with($imgPath, 'http'))
                            <img src="{{ $imgPath }}" alt="{{ $product->name }}" style="max-width: 100%; height: 180px; object-fit: contain; border-radius: 12px;">
                        @else
                            <img src="{{ Storage::url($imgPath) }}" alt="{{ $product->name }}" style="max-width: 100%; height: 180px; object-fit: contain; border-radius: 12px;">
                        @endif
                    @else
                        <div style="width: 100%; height: 180px; background: #f8fafc; display: flex; align-items: center; justify-content: center; color: #94a3b8; border-radius: 12px;">
                            <i class="fa-solid fa-image text-3xl"></i>
                        </div>
                    @endif
                </a>
                
                <div style="padding: 1.5rem; border-top: 1px solid rgba(226, 232, 240, 0.6); background: #fafafb;">
                    <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.75rem; color: var(--color-navy-dark); min-height: 2.8rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4; transition: color 0.2s;" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color='var(--color-navy-dark)'">
                            {{ $product->name }}
                        </h3>
                    </a>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; flex-direction: column;">
                            @if($product->discount_price)
                                <span style="font-size: 0.9rem; text-decoration: line-through; color: #94a3b8; margin-bottom: -0.25rem;">฿{{ number_format($product->price, 2) }}</span>
                                <span style="font-size: 1.25rem; font-weight: 800; color: var(--color-accent);">฿{{ number_format($product->discount_price, 2) }}</span>
                            @else
                                <span style="font-size: 1.25rem; font-weight: 800; color: var(--color-navy-light);">฿{{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <!-- Wishlist Toggle (AJAX) -->
                            @php 
                                $isFavorite = auth()->check() && \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                            @endphp
                            <button type="button" class="wishlist-toggle-btn" data-product-id="{{ $product->id }}" title="เพิ่มในสินค้าที่ชอบ" style="background: white; border: 1px solid rgba(226, 232, 240, 0.8); color: {{ $isFavorite ? '#ef4444' : '#94a3b8' }}; width: 42px; height: 42px; border-radius: 50%; cursor: pointer; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; transition: all 0.2s; box-shadow: 0 4px 6px rgba(0,0,0,0.03);" onmouseover="this.style.transform='scale(1.1)'; this.style.borderColor='#ef4444';" onmouseout="this.style.transform='scale(1)'; this.style.borderColor='rgba(226, 232, 240, 0.8)';">
                                <i class="fa-{{ $isFavorite ? 'solid' : 'regular' }} fa-heart"></i>
                            </button>

                            <!-- Add to Cart (Ajax-enabled) -->
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="ajax-add-to-cart-form" style="margin: 0;">
                                @csrf
                                <button type="submit" title="เพิ่มลงตะกร้า" style="background: var(--color-navy); color: white; border: none; width: 42px; height: 42px; border-radius: 50%; cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center; transition: all 0.2s; box-shadow: 0 4px 10px rgba(27, 42, 71, 0.15);" onmouseover="this.style.transform='scale(1.1)'; this.style.background='var(--color-accent)';" onmouseout="this.style.transform='scale(1)'; this.style.background='var(--color-navy)';">
                                    <i class="fa-solid fa-basket-shopping"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; color: #94a3b8; background: white; border-radius: 20px; border: 1px solid rgba(226, 232, 240, 0.8);">
                    <i class="fa-solid fa-box-open text-5xl mb-3"></i>
                    <p>ไม่พบสินค้าที่ตรงตามตัวกรองนี้</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div style="margin-top: 2rem;">
            {{ $products->links() }}
        </div>
    </main>

</div>
@endsection
