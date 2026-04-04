<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name'))</title>

        @include('layouts.partials.favicon')

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&family=source-serif-4:400,500,600,700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#f5f3ef] text-gray-900">
        @include('layouts.partials.site-nav')

        <main class="pt-28 pb-16 md:pb-20 px-4 sm:px-6 lg:px-8 min-h-[calc(100vh-8rem)]">
            <div class="max-w-[440px] mx-auto">
                @unless(request()->routeIs('login', 'register', 'password.request'))
                    @php $siteName = \App\Models\Setting::get('site_name', config('app.name')); @endphp
                    <a href="{{ route('home') }}" class="block text-center mb-8 group">
                        <span class="text-2xl sm:text-3xl font-serif font-semibold text-[#111827] tracking-tight group-hover:text-lime-800 transition-colors">{{ $siteName }}</span>
                    </a>
                @endunless

                <div class="rounded-[28px] bg-white border border-[#e6e1d8] shadow-xl shadow-black/5 overflow-hidden">
                    <div class="px-8 py-10 sm:px-10 sm:py-12">
                        {{ $slot }}
                    </div>
                </div>

                <p class="text-center mt-8 text-sm text-gray-500">
                    <a href="{{ route('home') }}" class="text-[#111827] font-medium hover:text-lime-700 transition-colors">← Back to home</a>
                </p>
            </div>
        </main>

        @include('layouts.partials.footer')
    </body>
</html>
