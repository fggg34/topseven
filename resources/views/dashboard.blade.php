@php
    $enquiryStatusLabels = [
        'new' => __('New'),
        'pending' => __('Pending'),
        'confirmed' => __('Confirmed'),
        'contacted' => __('Contacted'),
        'cancelled' => __('Cancelled'),
    ];
@endphp
<x-app-layout>
    {{-- Hero --}}
    <div class="relative w-full overflow-hidden bg-[#111827]">
        <div class="absolute inset-0 bg-cover bg-center opacity-35" style="background-image: url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1600&h=500&fit=crop');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#111827]/95 via-[#111827]/70 to-[#111827]/50"></div>
        <div class="relative max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-[80px] py-10 md:py-12 min-h-[220px]">
            <p class="text-xs font-medium uppercase tracking-wider text-white/50 mb-2">{{ __('My account') }}</p>
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-serif font-semibold text-white tracking-tight leading-tight">{{ __('Hello, :name', ['name' => auth()->user()->name]) }}</h1>
            <p class="mt-2 text-base text-white/65 max-w-xl">{{ __('Package enquiries and saved trips in one place.') }}</p>
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 mt-6 text-sm font-semibold text-white/90 hover:text-white transition-colors">
                <i class="fa-solid fa-gear text-sm"></i>
                {{ __('Account settings') }}
            </a>
        </div>
    </div>

    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-[80px] -mt-6 relative z-10 pb-16 md:pb-24">

        @if(session('success'))
            <div class="mb-8 flex items-center gap-3 px-5 py-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-12">
            <div class="bg-white rounded-2xl border border-[#e6e1d8] shadow-sm p-6 flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-lime-100 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-paper-plane text-lime-800 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-[#111827] tabular-nums">{{ $enquiriesCount ?? 0 }}</p>
                    <p class="text-sm text-gray-500">{{ __('Package enquiries') }}</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-[#e6e1d8] shadow-sm p-6 flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-heart text-amber-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-[#111827] tabular-nums">{{ $wishlistTours->count() }}</p>
                    <p class="text-sm text-gray-500">{{ __('Saved packages') }}</p>
                </div>
            </div>
        </div>

        <div class="space-y-12 lg:space-y-14">

            {{-- Enquiries --}}
            <section>
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-xl md:text-2xl font-serif font-semibold text-[#111827]">{{ __('Your enquiries') }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ __('Requests you sent from travel package pages. Estimated total uses the listed “from” price × guests.') }}</p>
                    </div>
                    <a href="{{ route('tours.index') }}" class="text-sm font-semibold text-lime-700 hover:text-lime-800 inline-flex items-center gap-1.5">
                        {{ __('Browse travel packages') }}
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="bg-white rounded-[28px] border border-[#e6e1d8] shadow-sm overflow-hidden">
                    @if($enquiries->isEmpty())
                        <div class="p-12 md:p-16 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fa-regular fa-envelope text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-[#111827] font-semibold text-lg">{{ __('No enquiries yet') }}</p>
                            <p class="text-sm text-gray-500 mt-2 max-w-md mx-auto mb-8">{{ __('When you enquire about a package, it will appear here with guest count and an estimated total.') }}</p>
                            <a href="{{ route('tours.index') }}" class="inline-flex items-center gap-2 rounded-full bg-[#111827] text-white text-sm font-semibold px-7 py-3 hover:bg-gray-900 transition-colors">
                                <i class="fa-solid fa-compass text-xs"></i>
                                {{ __('Explore packages') }}
                            </a>
                        </div>
                    @else
                        <ul class="divide-y divide-[#e6e1d8]">
                            @foreach($enquiries as $enquiry)
                                @php
                                    $tour = $enquiry->tour;
                                    $est = $enquiry->estimatedTotal();
                                    $currency = ($tour?->currency === 'EUR' || ! $tour?->currency) ? '€' : (($tour?->currency === 'USD') ? '$' : ($tour?->currency ?? '€').' ');
                                    $decimals = ($est !== null && $est != floor($est)) ? 2 : 0;
                                    $img = $tour?->images?->first();
                                    $imageUrl = $img?->url ?? 'https://placehold.co/160x120/e5e7eb/6b7280?text=Package';
                                @endphp
                                <li class="p-6 md:p-8 hover:bg-[#faf9f6] transition-colors">
                                    <div class="flex flex-col lg:flex-row lg:items-stretch gap-6">
                                        <a href="{{ $tour ? route('tours.show', $tour->slug) : '#' }}" class="block flex-shrink-0 w-full lg:w-44 aspect-[4/3] rounded-2xl overflow-hidden bg-gray-100">
                                            <img src="{{ $imageUrl }}" alt="" class="w-full h-full object-cover" loading="lazy">
                                        </a>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-start justify-between gap-3">
                                                <div>
                                                    <a href="{{ $tour ? route('tours.show', $tour->slug) : '#' }}" class="text-lg md:text-xl font-semibold text-[#111827] hover:text-lime-800 transition-colors line-clamp-2">
                                                        {{ $tour?->title ?? __('Travel package') }}
                                                    </a>
                                                    <p class="text-sm text-gray-500 mt-1">{{ __('Submitted') }} {{ $enquiry->created_at->translatedFormat('j M Y, H:i') }}</p>
                                                </div>
                                                <span class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-full
                                                    @if($enquiry->status === 'confirmed') bg-emerald-50 text-emerald-800
                                                    @elseif($enquiry->status === 'contacted') bg-amber-50 text-amber-900
                                                    @elseif($enquiry->status === 'cancelled') bg-gray-100 text-gray-600
                                                    @else bg-sky-50 text-sky-900 @endif">
                                                    {{ $enquiryStatusLabels[$enquiry->status] ?? ucfirst($enquiry->status) }}
                                                </span>
                                            </div>
                                            <div class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-sm text-gray-600">
                                                <span class="inline-flex items-center gap-2">
                                                    <i class="fa-solid fa-users text-gray-400"></i>
                                                    {{ $enquiry->guests }} {{ Str::plural('guest', $enquiry->guests) }}
                                                </span>
                                                @if($enquiry->departure_date || $enquiry->return_date)
                                                    <span class="inline-flex items-center gap-2">
                                                        <i class="fa-regular fa-calendar text-gray-400"></i>
                                                        @if($enquiry->departure_date)
                                                            {{ $enquiry->departure_date->translatedFormat('j M Y') }}
                                                        @endif
                                                        @if($enquiry->departure_date && $enquiry->return_date)
                                                            – {{ $enquiry->return_date->translatedFormat('j M Y') }}
                                                        @elseif($enquiry->return_date)
                                                            {{ $enquiry->return_date->translatedFormat('j M Y') }}
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>
                                            @if($est !== null)
                                                <p class="mt-4 text-base md:text-lg font-bold text-[#111827]">
                                                    Estimated total: <span class="tabular-nums">{{ $currency }}{{ number_format($est, $decimals) }}</span>
                                                    <span class="text-sm font-normal text-gray-500">(from price × {{ $enquiry->guests }} {{ Str::plural('guest', $enquiry->guests) }})</span>
                                                </p>
                                            @else
                                                <p class="mt-4 text-sm text-gray-500">{{ __('Price on request — contact us for a quote.') }}</p>
                                            @endif
                                            @if($enquiry->message)
                                                <p class="mt-3 text-sm text-gray-600 border-l-2 border-[#e6e1d8] pl-4 py-0.5">{{ Str::limit($enquiry->message, 280) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </section>

            {{-- Wishlist --}}
            <section>
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-xl md:text-2xl font-serif font-semibold text-[#111827]">{{ __('Saved travel packages') }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ __('From your wishlist') }}</p>
                    </div>
                    <a href="{{ route('tours.index') }}" class="text-sm font-semibold text-lime-700 hover:text-lime-800 hidden sm:inline-flex items-center gap-1.5">
                        {{ __('Explore more') }}
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="bg-white rounded-[28px] border border-[#e6e1d8] shadow-sm overflow-hidden">
                    @if($wishlistTours->isEmpty())
                        <div class="p-12 md:p-16 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-amber-50 flex items-center justify-center mx-auto mb-4">
                                <i class="fa-regular fa-heart text-amber-500 text-2xl"></i>
                            </div>
                            <p class="text-[#111827] font-semibold text-lg">{{ __('Nothing saved yet') }}</p>
                            <p class="text-sm text-gray-500 mt-2 mb-8">{{ __('Heart a package to save it here.') }}</p>
                            <a href="{{ route('tours.index') }}" class="inline-flex items-center gap-2 rounded-full bg-[#111827] text-white text-sm font-semibold px-7 py-3 hover:bg-gray-900 transition-colors">
                                {{ __('Browse packages') }}
                            </a>
                        </div>
                    @else
                        <div class="p-6 md:p-8">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                                @foreach($wishlistTours as $tour)
                                    <div class="group relative rounded-2xl border border-[#e6e1d8] overflow-hidden hover:border-lime-300 hover:shadow-md transition-all bg-[#faf9f6]">
                                        <form action="{{ route('wishlist.destroy', $tour) }}" method="POST" class="absolute top-3 right-3 z-10">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-rose-500 hover:bg-rose-50 transition-colors" title="{{ __('Remove') }}">
                                                <i class="fa-solid fa-heart text-sm"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('tours.show', $tour->slug) }}" class="block p-4">
                                            @php
                                                $firstImg = $tour->images->first();
                                                $imageUrl = $firstImg?->url ?? 'https://placehold.co/400x300/e5e7eb/6b7280?text=Package';
                                            @endphp
                                            <div class="aspect-[4/3] rounded-xl overflow-hidden bg-gray-200 mb-3">
                                                <img src="{{ $imageUrl }}" alt="{{ $tour->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                            </div>
                                            <h3 class="font-semibold text-[#111827] group-hover:text-lime-800 transition line-clamp-2 pr-10">{{ $tour->title }}</h3>
                                            @if($tour->price)
                                                <p class="mt-1 text-sm font-medium text-gray-600">{{ __('From') }} €{{ number_format($tour->price, $tour->price != floor($tour->price) ? 2 : 0) }}</p>
                                            @endif
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
