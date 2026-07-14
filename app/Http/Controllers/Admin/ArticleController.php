<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->get();
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('articles', 'public');
                $imagePaths[] = $path;
            }
        }

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'author_name' => $request->author_name ?? (auth()->user()->name ?? 'Admin'),
            'images' => $imagePaths,
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('central_admin.articles.index')->with('success', 'สร้างบทความสำเร็จ');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'remove_images' => 'nullable|array',
        ]);

        $imagePaths = $article->images ?? [];

        // Handle image removal
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $img) {
                if (($key = array_search($img, $imagePaths)) !== false) {
                    unset($imagePaths[$key]);
                    Storage::disk('public')->delete($img);
                }
            }
            $imagePaths = array_values($imagePaths); // Re-index
        }

        // Handle new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('articles', 'public');
                $imagePaths[] = $path;
            }
        }

        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'author_name' => $request->author_name,
            'images' => $imagePaths,
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('central_admin.articles.index')->with('success', 'แก้ไขบทความสำเร็จ');
    }

    public function destroy(Article $article)
    {
        if ($article->images) {
            foreach ($article->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }
        $article->delete();
        return redirect()->route('central_admin.articles.index')->with('success', 'ลบบทความสำเร็จ');
    }
}
