@props(['post'])

@php
    $imageUrl = $post->featured_image_url
        ?? 'https://placehold.co/600x400/e5e7eb/6b7280?text=Blog';
@endphp
<article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
    <a href="{{ route('blog.show', $post->slug) }}" class="block">
        <div class="aspect-[16/10] overflow-hidden rounded-t-lg bg-gray-200">
            <img src="{{ $imageUrl }}" alt="{{ $post->title }}" class="w-full h-full object-cover" loading="lazy">
        </div>
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 line-clamp-2 leading-snug">{{ $post->title }}</h3>
            <p class="mt-3 text-sm text-gray-600 line-clamp-3 leading-relaxed">{{ Str::limit($post->excerpt_plain !== '' ? $post->excerpt_plain : strip_tags($post->content_html), 150) }}</p>
            <p class="mt-4 text-xs text-gray-500">{{ $post->published_at?->format('M d Y') }}</p>
        </div>
    </a>
</article>
