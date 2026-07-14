<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['images', 'brand', 'category']);

        // Search by keyword
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->input('q') . '%');
        }

        // Filter by multiple Brand IDs (Checkboxes)
        if ($request->has('brand_ids') && is_array($request->input('brand_ids'))) {
            $query->whereIn('brand_id', $request->input('brand_ids'));
        } elseif ($request->filled('brand_id')) {
            // Backward compatibility for single brand ID query
            $query->where('brand_id', $request->input('brand_id'));
        }

        // Filter by multiple Category IDs (Checkboxes)
        if ($request->has('category_ids') && is_array($request->input('category_ids'))) {
            $query->whereIn('category_id', $request->input('category_ids'));
        } elseif ($request->filled('category_id')) {
            // Backward compatibility for single category ID query
            $query->where('category_id', $request->input('category_id'));
        }

        // Filter by Min/Max Price (Checks discount_price if available, otherwise regular price)
        if ($request->filled('min_price')) {
            $query->where(function($q) use ($request) {
                $q->where(function($sub) use ($request) {
                    $sub->whereNotNull('discount_price')
                        ->where('discount_price', '>=', $request->input('min_price'));
                })->orWhere(function($sub) use ($request) {
                    $sub->whereNull('discount_price')
                        ->where('price', '>=', $request->input('min_price'));
                });
            });
        }
        if ($request->filled('max_price')) {
            $query->where(function($q) use ($request) {
                $q->where(function($sub) use ($request) {
                    $sub->whereNotNull('discount_price')
                        ->where('discount_price', '<=', $request->input('max_price'));
                })->orWhere(function($sub) use ($request) {
                    $sub->whereNull('discount_price')
                        ->where('price', '<=', $request->input('max_price'));
                });
            });
        }

        // Filter for discounted/on-sale products only
        if ($request->boolean('on_sale')) {
            $query->whereNotNull('discount_price');
        }

        $products = $query->paginate(12)->withQueryString();
        $brands = Brand::all();
        $categories = Category::all();

        return view('products.index', compact('products', 'brands', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['images', 'brand', 'category', 'reviews.user']);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
        return view('products.show', compact('product', 'relatedProducts'));
    }
}
