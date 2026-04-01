@extends('layouts.site')

@section('title', 'Blog - ' . config('app.name'))
@section('description', 'Travel tips, destination guides and news.')

@section('content')
<div class="relative w-full overflow-hidden bg-[#111827]" style="height: 380px;">
    <div class="absolute inset-0 bg-cover bg-center opacity-40" style="background-image: url('https://images.unsplash.com/photo-1488085061387-422e29b40080?w=1920&h=600&fit=crop');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#111827]/80 via-transparent to-[#111827]/40"></div>
    <div class="absolute inset-0 flex items-end">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 w-full pb-12">
            <nav class="text-sm mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5">
                    <li><a href="{{ route('home') }}" class="text-white/60 hover:text-white transition">Home</a></li>
                    <li class="text-white/40">/</li>
                    <li class="text-white">Blog</li>
                </ol>
            </nav>
            <h1 class="text-4xl md:text-6xl font-serif text-white tracking-tight">Stories & Guides</h1>
            <p class="mt-3 text-lg text-white/70 max-w-xl">Discover travel inspiration, insider tips, and destination guides curated by our experts.</p>
        </div>
    </div>
</div>

<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
    @if($categories->isNotEmpty())
        <div class="flex flex-wrap items-center gap-3 mb-12">
            <a href="{{ route('blog.index') }}"
               class="px-5 py-2.5 text-sm font-semibold tracking-wider uppercase transition-colors {{ !request('category') ? 'bg-[#111827] text-white' : 'bg-transparent border border-[#d1cdc4] text-[#111827] hover:bg-[#111827] hover:text-white hover:border-[#111827]' }}">
                All
            </a>
            @foreach($categories as $c)
                <a href="{{ route('blog.index', ['category' => $c->slug]) }}"
                   class="px-5 py-2.5 text-sm font-semibold tracking-wider uppercase transition-colors {{ request('category') === $c->slug ? 'bg-[#111827] text-white' : 'bg-transparent border border-[#d1cdc4] text-[#111827] hover:bg-[#111827] hover:text-white hover:border-[#111827]' }}">
                    {{ $c->name }}
                </a>
            @endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($posts as $post)
            @php
                $imageUrl = $post->featured_image
                    ? \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image)
                    : 'https://placehold.co/600x400/e5e7eb/6b7280?text=Blog';
            @endphp
            <article class="group">
                <a href="{{ route('blog.show', $post->slug) }}" class="block">
                    <div class="aspect-[16/10] overflow-hidden bg-gray-100">
                        <img src="{{ $imageUrl }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    </div>
                    <div class="pt-5">
                        <div class="flex items-center gap-3 text-[12px] text-[#111827]/50 uppercase tracking-wider mb-3">
                            @if($post->category)
                                <span class="font-semibold text-[#111827]">{{ $post->category->name }}</span>
                                <span>&bull;</span>
                            @endif
                            <span>{{ ($post->published_at ?? $post->created_at)?->format('M d, Y') }}</span>
                        </div>
                        <h3 class="text-xl font-serif text-[#111827] line-clamp-2 leading-snug group-hover:underline decoration-1 underline-offset-4">{{ $post->title }}</h3>
                        <p class="mt-3 text-[15px] text-[#6a6a6a] line-clamp-3 leading-relaxed">{{ Str::limit(strip_tags($post->excerpt ?? $post->content ?? ''), 150) }}</p>
                        <span class="inline-block mt-4 text-[13px] font-semibold uppercase tracking-wider text-[#111827] border-b border-[#111827]">Read article</span>
                    </div>
                </a>
            </article>
        @empty
            <div class="col-span-full text-center py-20">
                <p class="text-lg text-[#6a6a6a] font-serif">No articles yet. Check back soon for travel stories and guides.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-12">
        {{ $posts->links() }}
    </div>
</div>
@endsection
