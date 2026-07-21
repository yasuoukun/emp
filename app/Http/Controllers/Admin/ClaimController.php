<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Claim;

class ClaimController extends Controller
{
    public function index()
    {
        $claims = Claim::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.claims.index', compact('claims'));
    }

    public function show(Claim $claim)
    {
        return view('admin.claims.show', compact('claim'));
    }

    public function update(Request $request, Claim $claim)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,received,in_progress,completed,cancelled',
            'estimated_cost' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string',
        ]);

        $claim->update($validated);

        return redirect()->route('admin.claims.show', $claim->id)
            ->with('success', 'อัปเดตสถานะการเคลม/ส่งซ่อมเรียบร้อยแล้ว');
    }

    public function destroy(Claim $claim)
    {
        $claim->delete();
        return redirect()->route('admin.claims.index')
            ->with('success', 'ลบรายการเคลม/ส่งซ่อมเรียบร้อยแล้ว');
    }
}
