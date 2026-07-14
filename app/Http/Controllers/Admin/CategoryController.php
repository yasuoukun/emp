<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('central_admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('central_admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Category::create($request->all());
        return redirect()->route('central_admin.categories.index')->with('success', 'หมวดหมู่ถูกสร้างเรียบร้อยแล้ว');
    }

    public function edit(Category $category)
    {
        return view('central_admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category->update($request->all());
        return redirect()->route('central_admin.categories.index')->with('success', 'แก้ไขหมวดหมู่เรียบร้อยแล้ว');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('central_admin.categories.index')->with('success', 'ลบหมวดหมู่เรียบร้อยแล้ว');
    }
}
