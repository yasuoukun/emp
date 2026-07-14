<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Quotation;

class QuotationController extends Controller
{
    public function generate(Request $request)
    {
        $cart = session()->get('cart', []);
        
        // Filter cart items by items query param or checkout_items session if applicable
        $selectedQuery = $request->query('items');
        if ($selectedQuery) {
            $selectedIds = explode(',', $selectedQuery);
        } else {
            $selectedIds = session()->get('checkout_items', []);
        }
        
        if (count($selectedIds) > 0) {
            $cart = array_filter($cart, function($key) use ($selectedIds) {
                return in_array($key, $selectedIds);
            }, ARRAY_FILTER_USE_KEY);
        }

        // Fetch all products so users can add products directly from the interface
        $allProducts = Product::orderBy('name')->get(['id', 'name', 'price']);

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $discount = session()->has('coupon') ? session('coupon')->discount_amount : 0;
        $netTotal = max(0, $total - $discount);
        
        // Assume VAT is 7% included
        $vat = $netTotal - ($netTotal / 1.07);
        $beforeVat = $netTotal - $vat;

        $quoteNo = 'QT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        $date = date('d/m/Y');
        $validUntil = date('d/m/Y', strtotime('+30 days'));

        return view('quotation', compact('cart', 'total', 'discount', 'netTotal', 'vat', 'beforeVat', 'quoteNo', 'date', 'validUntil', 'allProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cust_name' => 'required|string|max:255',
            'cust_org' => 'nullable|string|max:255',
            'cust_tax_id' => 'nullable|string|max:50',
            'cust_phone' => 'nullable|string|max:50',
            'cust_email' => 'nullable|email|max:255',
            'cust_address' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
            'subtotal' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'net_total' => 'required|numeric',
            'vat' => 'required|numeric',
            'before_vat' => 'required|numeric',
            'prepared_by' => 'nullable|string|max:255',
            'terms' => 'nullable|string',
        ]);

        $quoteNo = 'QT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        $quotation = Quotation::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'quote_no' => $quoteNo,
            'cust_name' => $request->cust_name,
            'cust_org' => $request->cust_org,
            'cust_tax_id' => $request->cust_tax_id,
            'cust_phone' => $request->cust_phone,
            'cust_email' => $request->cust_email,
            'cust_address' => $request->cust_address,
            'items' => $request->items,
            'subtotal' => $request->subtotal,
            'discount' => $request->discount ?? 0,
            'net_total' => $request->net_total,
            'vat' => $request->vat,
            'before_vat' => $request->before_vat,
            'prepared_by' => $request->prepared_by,
            'terms' => $request->terms,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ส่งใบเสนอราคาออนไลน์เรียบร้อยแล้ว!',
            'quote_no' => $quoteNo,
            'redirect' => auth()->check() ? route('dashboard') : route('home'),
        ]);
    }
}
