<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending_verification')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $totalProducts = Product::count();
        $unreadChats = \App\Models\Message::whereNull('receiver_id')->where('is_read', false)->count();

        // Financial stats
        $totalRevenue = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])->sum('total_amount');
        $monthlyRevenue = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        // Sales last 7 days for line chart
        $salesLast7Days = [];
        $labelsLast7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $sum = Order::whereIn('status', ['confirmed', 'shipped', 'delivered'])
                ->whereDate('created_at', $date)
                ->sum('total_amount');
            $salesLast7Days[] = (float)$sum;
            $labelsLast7Days[] = now()->subDays($i)->locale('th')->translatedFormat('j M');
        }

        // Order statuses for pie chart
        $orderStatuses = [
            'รอดำเนินการ' => Order::where('status', 'pending')->count(),
            'รอตรวจสอบสลิป' => Order::where('status', 'pending_verification')->count(),
            'ชำระเงินแล้ว' => Order::where('status', 'confirmed')->count(),
            'จัดส่งแล้ว' => Order::where('status', 'shipped')->count(),
            'สำเร็จแล้ว' => Order::where('status', 'delivered')->count(),
            'ยกเลิกแล้ว' => Order::where('status', 'cancelled')->count(),
        ];

        // 1. Top Selling Products
        $topSellingProducts = \App\Models\OrderItem::select('product_id', \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_quantity'), \Illuminate\Support\Facades\DB::raw('SUM(price * quantity) as total_sales'))
            ->whereHas('order', function($q) {
                $q->whereIn('status', ['confirmed', 'shipped', 'delivered']);
            })
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->with('product.images')
            ->take(5)
            ->get();

        // 2. Most Wishlisted Products
        $mostWishlistedProducts = \App\Models\Wishlist::select('product_id', \Illuminate\Support\Facades\DB::raw('COUNT(*) as wishlist_count'))
            ->groupBy('product_id')
            ->orderBy('wishlist_count', 'desc')
            ->with('product.images')
            ->take(5)
            ->get();

        // 3. Highest Rated Products
        $topRatedProducts = Product::withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->with('images')
            ->having('reviews_count', '>', 0)
            ->orderBy('reviews_avg_rating', 'desc')
            ->take(5)
            ->get();
            
        if ($topRatedProducts->isEmpty()) {
            $topRatedProducts = Product::with('images')->where('is_popular', true)->take(5)->get();
        }

        // 4. Low Stock Alert Products
        $lowStockProducts = Product::with('images')
            ->where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        $totalWishlistsCount = \App\Models\Wishlist::count();
        $totalReviewsCount = \App\Models\Review::count();
        $avgRating = round(\App\Models\Review::avg('rating') ?: 5.0, 1);

        return view('admin.dashboard', compact(
            'totalOrders', 'pendingOrders', 'confirmedOrders', 'totalProducts', 'unreadChats',
            'totalRevenue', 'monthlyRevenue', 'salesLast7Days', 'labelsLast7Days', 'orderStatuses',
            'topSellingProducts', 'mostWishlistedProducts', 'topRatedProducts', 'lowStockProducts',
            'totalWishlistsCount', 'totalReviewsCount', 'avgRating'
        ));
    }
}
