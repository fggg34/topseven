@props(['posts'])

@php
    $posts = $posts ?? collect();
@endphp

@if($posts->isNotEmpty())
<section class="home-blog-stories-section mx-auto px-4 sm:px-6 lg:px-[80px] py-14">
    <div class="mx-auto w-full max-w-[1400px]">
        <p class="text-[15px] text-gray-700 mb-2">Get Inspired</p>
        <h2 class="text-[36px] md:text-[48px] font-serif font-semibold text-[#1f1f1f] leading-[1.05] mb-7">
            Travel stories to inspire you.
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($posts as $post)
                @php
                    $imageUrl = $post->featured_image
                        ? \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image)
                        : 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80';
                    $categoryLabel = trim((string) ($post->category?->name ?? 'Travel'));
                    $excerpt = trim(strip_tags($post->excerpt ?: $post->content ?: ''));
                @endphp
                <article class="group">
                    <a href="{{ route('blog.show', $post->slug) }}" class="block">
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
            @endforeach
        </div>
    </div>
</section>
@endif
