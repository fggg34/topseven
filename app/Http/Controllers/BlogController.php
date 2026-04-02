<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::query()
            ->where('is_published', true)
            ->where(function ($q): void {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        $posts = $query
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->paginate(9)
            ->withQueryString();
        $categories = BlogCategory::all();

        return view('pages.blog.index', compact('posts', 'categories'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->where('is_published', true)
            ->where(function ($q): void {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->with(['category', 'tags'])
            ->firstOrFail();

        $related = BlogPost::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->where(function ($q): void {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->where(function ($q) use ($post) {
                $q->where('blog_category_id', $post->blog_category_id)->orWhereNull('blog_category_id');
            })
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->limit(3)
            ->get();

        return view('pages.blog.show', compact('post', 'related'));
    }
}
