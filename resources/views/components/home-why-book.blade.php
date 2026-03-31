@props([
    'heading' => 'Why thousands book with us.',
    'cards',
])

@php
    $cards = $cards ?? collect();
@endphp

@if($cards->isNotEmpty())
<section class="home-why-book w-full bg-gray-100 py-16 md:py-20">
    <div class="w-full max-w-none px-4 sm:px-6 md:px-[80px]">
        <h2 class="text-4xl sm:text-5xl md:text-[2.75rem] lg:text-6xl font-bold text-gray-900 text-left tracking-tight leading-[1.1] mb-12 md:mb-16 mx-auto">
            {{ $heading }}
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-10">
            @foreach($cards as $card)
                <div class="bg-white rounded-2xl p-8 lg:p-10 shadow-sm border border-gray-100 flex flex-col h-full">
                    <div class="flex-shrink-0 mb-6">
                        @if($card->icon_url)
                            <img
                                src="{{ $card->icon_url }}"
                                alt=""
                                class="w-14 h-14 object-contain object-left"
                                loading="lazy"
                                width="56"
                                height="56"
                            >
                        @else
                            <div class="w-14 h-14 rounded-xl bg-gray-100 border border-gray-200/80" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3 leading-snug">{{ $card->title }}</h3>
                    <div class="text-gray-600 text-[15px] leading-relaxed flex-1 [&_p]:my-2 [&_p:first-child]:mt-0 [&_p:last-child]:mb-0 [&_a]:font-medium [&_a]:text-gray-900 [&_a]:underline [&_ul]:list-disc [&_ul]:pl-5 [&_ul]:my-2 [&_ol]:list-decimal [&_ol]:pl-5 [&_ol]:my-2 [&_strong]:font-semibold [&_strong]:text-gray-900">
                        {!! $card->description !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
