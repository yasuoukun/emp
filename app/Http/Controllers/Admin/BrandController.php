<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('central_admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('central_admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Brand::create($request->all());
        return redirect()->route('central_admin.brands.index')->with('success', 'แบรนด์ถูกสร้างเรียบร้อยแล้ว');
    }

    public function edit(Brand $brand)
    {
        return view('central_admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $brand->update($request->all());
        return redirect()->route('central_admin.brands.index')->with('success', 'แก้ไขแบรนด์เรียบร้อยแล้ว');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('central_admin.brands.index')->with('success', 'ลบแบรนด์เรียบร้อยแล้ว');
    }
}
