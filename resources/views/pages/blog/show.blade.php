@extends('layouts.site')

@section('title', $post->meta_title ?: $post->title . ' - ' . config('app.name'))
@section('description', $post->meta_description ?: Str::limit(strip_tags($post->excerpt ?? ''), 160))

@section('content')
<div class="relative w-full overflow-hidden bg-[#111827]" style="height: 340px;">
    @if($post->featured_image)
        <div class="absolute inset-0 bg-cover bg-center opacity-35" style="background-image: url('{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image) }}');"></div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-[#111827]/80 via-transparent to-[#111827]/40"></div>
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-[900px] mx-auto px-4 sm:px-6 lg:px-8 w-full pb-12">
            <nav class="text-sm mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5">
                    <li><a href="{{ route('home') }}" class="text-white/60 hover:text-white transition">Home</a></li>
                    <li class="text-white/40">/</li>
                    <li><a href="{{ route('blog.index') }}" class="text-white/60 hover:text-white transition">Blog</a></li>
                    <li class="text-white/40">/</li>
                    <li class="text-white truncate max-w-[200px]">{{ $post->title }}</li>
                </ol>
            </nav>
            <div class="flex items-center gap-3 text-[12px] text-white/50 uppercase tracking-wider mb-3">
                @if($post->category)
                    <span class="font-semibold text-white/80">{{ $post->category->name }}</span>
                    <span>&bull;</span>
                @endif
                <span>{{ $post->published_at?->format('F j, Y') }}</span>
            </div>
            <h1 class="text-3xl md:text-5xl font-serif text-white tracking-tight leading-[1.1]">{{ $post->title }}</h1>
        </div>
    </div>
</div>

<article class="max-w-[900px] mx-auto px-4 sm:px-6 lg:px-8 py-14">
    @if($post->featured_image)
        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full mb-10" style="aspect-ratio: 16/9; object-fit: cover;">
    @endif
    <div class="blog-content prose prose-lg max-w-none prose-headings:font-serif prose-headings:text-[#111827] prose-p:text-[#4a4a4a] prose-p:leading-[1.8] prose-a:text-[#111827] prose-a:underline prose-a:underline-offset-4">
        {!! $post->content !!}
    </div>

    @if($post->category || $post->tags->isNotEmpty())
    <div class="mt-14 pt-8 border-t border-[#e6e1d8]">
        <div class="flex flex-wrap flex-col items-left gap-4 text-sm">
            @if($post->category)
                <div class="flex items-center gap-3">
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-[#111827]/50">Category</span>
                    <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}" class="inline-flex items-center px-4 py-1.5 bg-[#f8f6f2] text-[#111827] text-sm font-semibold hover:bg-[#eee9df] transition-colors">{{ $post->category->name }}</a>
                </div>
            @endif
            @if($post->tags->isNotEmpty())
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-[#111827]/50">Tags</span>
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" class="inline-flex items-center px-4 py-1.5 bg-[#f8f6f2] text-[#111827] text-sm font-medium hover:bg-[#eee9df] transition-colors">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif
</article>

@if($related->isNotEmpty())
<section class="border-t border-[#e6e1d8] bg-[#f8f6f2]">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-3xl font-serif text-[#111827] mb-8">Related articles</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($related as $p)
                @php
                    $relImageUrl = $p->featured_image
                        ? \Illuminate\Support\Facades\Storage::disk('public')->url($p->featured_image)
                        : 'https://placehold.co/600x400/e5e7eb/6b7280?text=Blog';
                @endphp
                <article class="group">
                    <a href="{{ route('blog.show', $p->slug) }}" class="block">
                        <div class="aspect-[16/10] overflow-hidden bg-gray-100">
                            <img src="{{ $relImageUrl }}" alt="{{ $p->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                        </div>
                        <div class="pt-5">
                            <p class="text-[12px] text-[#111827]/50 uppercase tracking-wider mb-2">{{ ($p->published_at ?? $p->created_at)?->format('M d, Y') }}</p>
                            <h3 class="text-xl font-serif text-[#111827] line-clamp-2 leading-snug group-hover:underline decoration-1 underline-offset-4">{{ $p->title }}</h3>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
