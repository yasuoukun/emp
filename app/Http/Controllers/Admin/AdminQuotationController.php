<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use Illuminate\Http\Request;

class AdminQuotationController extends Controller
{
    public function index()
    {
        $quotations = Quotation::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.quotations.index', compact('quotations'));
    }

    public function updateStatus(Request $request, Quotation $quotation)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,ordered',
        ]);

        $quotation->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'อัปเดตสถานะใบเสนอราคาเรียบร้อยแล้ว');
    }

    public function destroy(Quotation $quotation)
    {
        $quotation->delete();
        return redirect()->back()->with('success', 'ลบใบเสนอราคาเรียบร้อยแล้ว');
    }
}
