@extends('layouts.store')

@section('content')
<div class="container" style="padding: 3rem 1rem; max-width: 1200px; margin: 0 auto;">
    
    <!-- Back button -->
    <a href="{{ route('products.index') }}" style="display: inline-flex; align-items: center; gap: 8px; color: var(--color-navy); text-decoration: none; font-weight: 600; margin-bottom: 2rem; transition: color 0.2s;" onmouseover="this.style.color='var(--color-accent)'" onmouseout="this.style.color='var(--color-navy)'">
        ← กลับไปหน้าสินค้าทั้งหมด
    </a>

    <!-- Product Main Details Card -->
    <div style="background: white; border: 1px solid var(--color-silver); border-radius: 16px; padding: 2.5rem; display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03); margin-bottom: 4rem;">
        
        <!-- Left Column: Product Image Gallery -->
        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; background: var(--color-grey-bg); border-radius: 12px; padding: 2rem; border: 1px solid var(--color-silver-light);">
            @if($product->images->where('is_primary', true)->first())
                @php
                    $imgPath = $product->images->where('is_primary', true)->first()->image_path;
                @endphp
                @if(str_starts_with($imgPath, 'http'))
                    <img src="{{ $imgPath }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 400px; object-fit: contain;">
                @else
                    <img src="{{ Storage::url($imgPath) }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 400px; object-fit: contain;">
                @endif
            @else
                <div style="width: 100%; height: 350px; background: #eee; display: flex; align-items: center; justify-content: center; color: #999; font-size: 3rem;">📱</div>
            @endif
        </div>

        <!-- Right Column: Product Specs -->
        <div style="display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <!-- Brand & Category & SKU badges -->
                <div style="display: flex; gap: 10px; margin-bottom: 1rem; flex-wrap: wrap;">
                    <span style="background: var(--color-silver-light); color: var(--color-navy); padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                        แบรนด์: {{ $product->brand->name ?? 'ทั่วไป' }}
                    </span>
                    <span style="background: rgba(49, 130, 206, 0.1); color: var(--color-accent); padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                        หมวดหมู่: {{ $product->category->name ?? 'ทั่วไป' }}
                    </span>
                    @if($product->sku)
                    <span style="background: #F1F5F9; color: #475569; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; font-family: monospace;">
                        SKU: {{ $product->sku }}
                    </span>
                    @endif
                </div>

                <!-- Product Name -->
                <h1 style="font-size: 2.2rem; color: var(--color-navy-dark); font-weight: 700; margin: 0 0 1rem; line-height: 1.2;">
                    {{ $product->name }}
                </h1>

                <!-- Price and Discount -->
                <div style="display: flex; align-items: baseline; gap: 15px; margin-bottom: 1.5rem;">
                    @if($product->discount_price)
                        <span style="font-size: 2.2rem; font-weight: 700; color: var(--color-danger);">
                            ฿{{ number_format($product->discount_price, 2) }}
                        </span>
                        <span style="font-size: 1.2rem; text-decoration: line-through; color: var(--color-grey-light);">
                            ฿{{ number_format($product->price, 2) }}
                        </span>
                    @else
                        <span style="font-size: 2.2rem; font-weight: 700; color: var(--color-accent);">
                            ฿{{ number_format($product->price, 2) }}
                        </span>
                    @endif
                </div>

                <!-- Installment Preview Widget -->
                @php
                    $activePrice = $product->discount_price ?? $product->price;
                @endphp
                <div style="background: rgba(27, 42, 71, 0.04); border: 1px solid var(--color-silver); border-radius: 8px; padding: 12px 15px; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
                    <div style="font-size: 0.9rem; color: var(--color-navy-dark);">
                        💳 ผ่อนชำระเริ่มต้นเพียง <strong style="color: var(--color-accent); font-size: 1.05rem;">฿{{ number_format(round($activePrice / 10)) }}</strong> / เดือน (10 ด.)
                    </div>
                    <a href="{{ route('installment') }}?price={{ $activePrice }}" style="color: var(--color-navy); font-weight: bold; font-size: 0.85rem; text-decoration: underline;">
                        คำนวณดอกเบี้ย
                    </a>
                </div>

                <!-- Freebie/Gift Widget -->
                @if($product->freebie)
                <div style="background: rgba(229, 62, 62, 0.05); border: 1px dashed var(--color-danger); border-radius: 8px; padding: 12px 15px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 1.3rem;">🎁</span>
                    <div style="font-size: 0.9rem; color: var(--color-navy-dark); line-height: 1.4;">
                        <strong style="color: var(--color-danger);">ของแถมพิเศษ:</strong> {{ $product->freebie }}
                    </div>
                </div>
                @endif

                <!-- Stock availability -->
                <p style="font-size: 0.95rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 8px;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: {{ $product->stock > 0 ? 'var(--color-success)' : 'var(--color-danger)' }}; display: inline-block;"></span>
                    <strong style="color: var(--color-navy-dark);">สถานะ:</strong> 
                    <span style="color: {{ $product->stock > 0 ? 'var(--color-success)' : 'var(--color-danger)' }}; font-weight: 600;">
                        {{ $product->stock > 0 ? 'สินค้าพร้อมจำหน่าย (เหลือ '.$product->stock.' เครื่อง)' : 'สินค้าหมดชั่วคราว' }}
                    </span>
                </p>

                <!-- Description Section -->
                <div style="border-top: 1px solid var(--color-silver); padding-top: 1.5rem; margin-bottom: 2rem;">
                    <h3 style="font-size: 1.15rem; color: var(--color-navy-dark); font-weight: 700; margin-top: 0; margin-bottom: 0.75rem;">
                        รายละเอียดสินค้า
                    </h3>
                    <p style="color: var(--color-grey); font-size: 1.05rem; line-height: 1.6; margin: 0; white-space: pre-line;">
                        {{ $product->description ?? 'ไม่มีข้อมูลรายละเอียดสินค้าเพิ่มเติม' }}
                    </p>
                </div>

                <!-- Specifications Section -->
                @if($product->specifications)
                <div style="border-top: 1px solid var(--color-silver); padding-top: 1.5rem; margin-bottom: 2rem;">
                    <h3 style="font-size: 1.15rem; color: var(--color-navy-dark); font-weight: 700; margin-top: 0; margin-bottom: 0.75rem;">
                        สเปกสินค้า (Specifications)
                    </h3>
                    <p style="color: var(--color-grey); font-size: 1.05rem; line-height: 1.6; margin: 0; white-space: pre-line;">
                        {{ $product->specifications }}
                    </p>
                </div>
                @endif
            </div>

            <!-- Actions Section -->
            <div style="display: flex; gap: 15px; width: 100%;">
                <div style="flex-grow: 1;">
                    @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="ajax-add-to-cart-form" style="margin: 0;">
                        @csrf
                        <button type="submit" style="width: 100%; padding: 16px; background: linear-gradient(135deg, var(--color-navy) 0%, var(--color-navy-light) 100%); color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 1.1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; box-shadow: 0 10px 20px rgba(27,42,71,0.15); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                            <i class="fa-solid fa-basket-shopping"></i> เพิ่มลงตะกร้าสินค้า
                        </button>
                    </form>
                    @else
                    <button disabled style="width: 100%; padding: 16px; background: var(--color-grey-light); color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 1.1rem; cursor: not-allowed; display: flex; align-items: center; justify-content: center; gap: 12px;">
                        สินค้าหมดชั่วคราว
                    </button>
                    @endif
                </div>
                
                <div>
                    <!-- Wishlist Toggle -->
                    @php 
                        $isFavorite = auth()->check() && \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                    @endphp
                    <button type="button" onclick="toggleWishlist(this, '{{ $product->id }}')" style="background: white; border: 2px solid var(--color-silver); color: {{ $isFavorite ? 'red' : '#999' }}; padding: 16px; min-width: 60px; height: 56px; border-radius: 12px; cursor: pointer; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; transition: all 0.2s; box-shadow: 0 4px 6px rgba(0,0,0,0.02);" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                        {{ $isFavorite ? '❤️' : '🤍' }}
                    </button>
                </div>
            </div>

            <!-- LINE OA Contact Button -->
            <div style="margin-top: 15px;">
                <a href="https://line.me/ti/p/@dditcom" target="_blank" style="display: flex; align-items: center; justify-content: center; gap: 10px; background-color: #06c755; color: white; padding: 12px; border-radius: 12px; font-weight: 700; text-decoration: none; font-size: 1rem; transition: transform 0.2s; box-shadow: 0 4px 10px rgba(6,199,85,0.2);" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">
                    <i class="fa-brands fa-line" style="font-size: 1.4rem;"></i> สอบถามรายละเอียดเพิ่มเติมผ่าน LINE
                </a>
            </div>
        </div>

    </div>

    <!-- Product Reviews Section -->
    <div style="background: white; border: 1px solid var(--color-silver); border-radius: 16px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03); margin-bottom: 4rem;">
        <h2 style="font-size: 1.6rem; color: var(--color-navy-dark); margin-bottom: 1.5rem; font-weight: 700; border-left: 5px solid var(--color-navy); padding-left: 12px;">
            รีวิวและคะแนนสินค้า ({{ count($product->reviews) }})
        </h2>

        <!-- Write a Review (Only if logged in) -->
        @auth
        <div style="background: var(--color-grey-bg); border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem; border: 1px dashed var(--color-silver);">
            <h3 style="font-size: 1.1rem; color: var(--color-navy-dark); font-weight: 700; margin: 0 0 1rem;">✍️ เขียนรีวิวสินค้าของคุณ</h3>
            <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <div style="margin-bottom: 1rem; display: flex; align-items: center; gap: 15px;">
                    <label style="font-weight: 600; color: var(--color-navy-dark);">คะแนนความพึงพอใจ:</label>
                    <div style="display: flex; gap: 5px; font-size: 1.8rem; cursor: pointer; color: #cbd5e0;" id="star-rating-container">
                        <span class="star-item" data-value="1" style="transition: color 0.1s;">★</span>
                        <span class="star-item" data-value="2" style="transition: color 0.1s;">★</span>
                        <span class="star-item" data-value="3" style="transition: color 0.1s;">★</span>
                        <span class="star-item" data-value="4" style="transition: color 0.1s;">★</span>
                        <span class="star-item" data-value="5" style="transition: color 0.1s;">★</span>
                    </div>
                    <input type="hidden" name="rating" id="rating-hidden-input" value="5" required>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-navy-dark);">ความคิดเห็นของคุณ:</label>
                    <textarea name="comment" rows="3" placeholder="ระบุรายละเอียดความคิดเห็นเกี่ยวกับสินค้า..." style="width: 100%; padding: 10px; border: 1px solid var(--color-silver); border-radius: 8px; outline: none;" required></textarea>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.35rem; color: var(--color-navy-dark); font-size: 0.9rem;">📷 แนบรูปภาพ / วิดีโอรีวิวสินค้าประกอบการใช้งาน:</label>
                    <input type="file" name="media[]" multiple accept="image/*,video/*" style="font-size: 0.85rem; color: var(--color-grey);">
                </div>

                <button type="submit" style="background: var(--color-navy); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='var(--color-navy-light)'" onmouseout="this.style.background='var(--color-navy)'">ส่งรีวิว</button>
            </form>
        </div>
        @else
        <div style="background: #FFF8DC; border: 1px solid #FFE4B5; border-radius: 8px; padding: 1rem; text-align: center; color: #B8860B; font-weight: 500; margin-bottom: 2rem;">
            🔒 กรุณา <a href="{{ route('login') }}" style="color: #FF4500; text-decoration: underline; font-weight: bold;">เข้าสู่ระบบ</a> เพื่อเขียนรีวิวสินค้าชิ้นนี้
        </div>
        @endauth

        <!-- Reviews List -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            @forelse($product->reviews as $review)
            <div style="border-bottom: 1px solid var(--color-silver-light); padding-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <div>
                        <strong style="color: var(--color-navy-dark); font-size: 1.05rem;">👤 {{ $review->user->name ?? 'ลูกค้าทั่วไป' }}</strong>
                        <span style="color: var(--color-grey); font-size: 0.85rem; margin-left: 10px;">🕒 {{ $review->created_at->format('d/m/Y H:i') }} น.</span>
                    </div>
                    <div style="color: #FFD700; font-size: 1.1rem; letter-spacing: 2px;">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $review->rating ? '★' : '☆' }}
                        @endfor
                    </div>
                </div>
                <p style="margin: 0 0 10px; color: var(--color-navy-dark); font-size: 1rem; line-height: 1.5;">
                    {{ $review->comment }}
                </p>

                <!-- Render Review Media -->
                @if(!empty($review->media_paths) && count($review->media_paths) > 0)
                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 8px;">
                    @foreach($review->media_paths as $m)
                        @if(str_contains(strtolower($m), '.mp4') || str_contains(strtolower($m), '.mov'))
                            <video src="{{ Storage::url($m) }}" controls style="height: 100px; border-radius: 8px; border: 1px solid var(--color-silver);"></video>
                        @else
                            <a href="{{ Storage::url($m) }}" target="_blank">
                                <img src="{{ Storage::url($m) }}" style="height: 90px; width: 90px; object-fit: cover; border-radius: 8px; border: 1px solid var(--color-silver);">
                            </a>
                        @endif
                    @endforeach
                </div>
                @endif
            </div>
            @empty
            <p style="color: var(--color-grey); text-align: center; padding: 2rem 0; font-style: italic;">ยังไม่มีรีวิวสำหรับสินค้าชิ้นนี้ มาร่วมเป็นคนแรกที่รีวิวกันเถอะ!</p>
            @endforelse
        </div>
    </div>

    <!-- Related Products -->
    @if(count($relatedProducts) > 0)
    <div>
        <h2 style="font-size: 1.6rem; color: var(--color-navy-dark); margin-bottom: 1.5rem; font-weight: 700; border-left: 5px solid var(--color-navy); padding-left: 12px;">
            สินค้าอื่น ๆ ในหมวดหมู่นี้
        </h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">
            @foreach($relatedProducts as $rel)
            <a href="{{ route('products.show', $rel->id) }}" style="text-decoration: none; color: inherit; display: block;">
                <div style="background: white; border: 1px solid var(--color-silver); border-radius: 12px; overflow: hidden; transition: all 0.3s; display: flex; flex-direction: column; justify-content: space-between; height: 100%;" onmouseover="this.style.boxShadow='0 10px 20px rgba(0,0,0,0.06)'; this.style.transform='translateY(-3px)';" onmouseout="this.style.boxShadow='none'; this.style.transform='translateY(0)';">
                    <div style="padding: 1rem; text-align: center;">
                        @if($rel->images->where('is_primary', true)->first())
                            @php
                                $relImg = $rel->images->where('is_primary', true)->first()->image_path;
                            @endphp
                            @if(str_starts_with($relImg, 'http'))
                                <img src="{{ $relImg }}" alt="{{ $rel->name }}" style="max-width: 100%; height: 160px; object-fit: contain;">
                            @else
                                <img src="{{ Storage::url($relImg) }}" alt="{{ $rel->name }}" style="max-width: 100%; height: 160px; object-fit: contain;">
                            @endif
                        @else
                            <div style="width: 100%; height: 160px; background: #eee; display: flex; align-items: center; justify-content: center; color: #999;">No Image</div>
                        @endif
                    </div>
                    <div style="padding: 1.25rem; border-top: 1px solid var(--color-silver-light);">
                        <h4 style="font-size: 1rem; margin: 0 0 0.5rem; color: var(--color-navy-dark); font-weight: 600; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                            {{ $rel->name }}
                        </h4>
                        <span style="font-size: 1.1rem; font-weight: 700; color: var(--color-accent);">
                            ฿{{ number_format($rel->price, 2) }}
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>

<script>
    // AJAX wishlist toggle
    function toggleWishlist(btn, productId) {
        if (!{{ auth()->check() ? 'true' : 'false' }}) {
            window.location.href = "{{ route('login') }}";
            return;
        }
        
        fetch(`/wishlist/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.added) {
                    btn.innerHTML = '❤️';
                    btn.style.color = 'red';
                } else {
                    btn.innerHTML = '🤍';
                    btn.style.color = '#999';
                }
            }
        })
        .catch(err => console.error(err));
    }

    // Dynamic Star Rating Interaction
    document.addEventListener('DOMContentLoaded', function() {
        const starContainer = document.getElementById('star-rating-container');
        if (starContainer) {
            const stars = starContainer.querySelectorAll('.star-item');
            const ratingInput = document.getElementById('rating-hidden-input');

            function setStars(val) {
                stars.forEach(star => {
                    const starVal = parseInt(star.getAttribute('data-value'));
                    if (starVal <= val) {
                        star.style.color = '#FFD700'; // Gold
                    } else {
                        star.style.color = '#cbd5e0'; // Grey
                    }
                });
            }

            // Default to 5 stars
            setStars(5);

            stars.forEach(star => {
                star.addEventListener('mouseover', function() {
                    const val = parseInt(this.getAttribute('data-value'));
                    setStars(val);
                });

                star.addEventListener('mouseout', function() {
                    const val = parseInt(ratingInput.value) || 5;
                    setStars(val);
                });

                star.addEventListener('click', function() {
                    const val = parseInt(this.getAttribute('data-value'));
                    ratingInput.value = val;
                    setStars(val);
                });
            });
        }
    });
</script>

<style>
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
            gap: 2rem !important;
        }
    }
</style>
@endsection
