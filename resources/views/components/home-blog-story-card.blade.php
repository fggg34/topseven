@props(['post'])

@php
    $imageUrl = $post->featured_image_url
        ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80';
    $categoryLabel = trim((string) ($post->category?->name ?? 'Travel'));
    $excerpt = $post->excerpt_plain !== '' ? $post->excerpt_plain : strip_tags($post->content_html);
    $excerpt = trim($excerpt);
@endphp
<article class="group h-full">
    <a href="{{ route('blog.show', $post->slug) }}" class="block h-full">
        <div class="relative overflow-hidden rounded-md aspect-[16/9]">
            <img src="{{ $imageUrl }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.04]" loading="lazy">

            <div class="absolute top-3 left-3">
                <span class="inline-flex rounded-full bg-white/95 px-3 py-1 text-[11px] font-medium text-gray-800">
                    {{ $categoryLabel }}
                </span>
            </div>
            <div class="absolute top-3 right-3">
                <span class="inline-flex w-7 h-7 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm border border-white/50 text-white text-xs">
                    <i class="fa-regular fa-heart"></i>
                </span>
            </div>
        </div>

        <h3 class="mt-5 text-[34px] leading-[1.03] font-serif text-[#1f1f1f] line-clamp-2">
            {{ $post->title }}
        </h3>
        <p class="mt-3 text-[17px] leading-[1.45] text-[#414141] line-clamp-3">
            {{ \Illuminate\Support\Str::limit($excerpt, 145) }}
        </p>
        <span class="mt-5 inline-flex text-[15px] font-medium text-[#1f1f1f] group-hover:underline">
            Read more
        </span>
    </a>
</article>
