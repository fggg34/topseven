@php
    $waRaw = trim((string) \App\Models\Setting::get('whatsapp_number', ''));
    $waDigits = preg_replace('/\D+/', '', $waRaw) ?: '';
    if ($waDigits === '') {
        $waDigits = preg_replace('/\D+/', '', (string) \App\Models\Setting::get('contact_phone', '')) ?: '';
    }
    $siteName = \App\Models\Setting::get('site_name', config('app.name'));
@endphp
@if(strlen($waDigits) >= 9)
<div
    class="fixed bottom-5 right-5 z-[90] flex flex-col items-end gap-3 sm:bottom-6 sm:right-6 md:bottom-8 md:right-8"
    x-data="{
        open: false,
        message: '',
        phone: @js($waDigits),
        toggle() { this.open = !this.open; },
        sendWhatsApp() {
            const intro = 'Përshëndetje! Mesazh nga ' + window.location.href + ':';
            const body = (this.message || '').trim();
            const text = body ? (intro + '\n\n' + body) : intro;
            window.open('https://wa.me/' + this.phone + '?text=' + encodeURIComponent(text), '_blank', 'noopener,noreferrer');
            this.message = '';
            this.open = false;
        },
    }"
    @keydown.escape.window="open = false"
>
    <div
        id="whatsapp-chat-panel"
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
        @click.outside="open = false"
        class="w-[min(100vw-2.5rem,22rem)] overflow-hidden rounded-2xl border border-[#e6e1d8] bg-white shadow-2xl shadow-black/15 ring-1 ring-black/5"
        role="dialog"
        aria-modal="true"
        aria-labelledby="whatsapp-chat-title"
    >
        <div class="flex items-center justify-between gap-2 bg-brand-heading px-4 py-3 text-white">
            <div class="flex min-w-0 items-center gap-2.5">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white/10 ring-1 ring-white/20">
                    <i class="fa-brands fa-whatsapp text-xl text-[#25D366]" aria-hidden="true"></i>
                </span>
                <div class="min-w-0">
                    <p id="whatsapp-chat-title" class="font-serif text-base font-semibold leading-tight tracking-tight">WhatsApp</p>
                    <p class="truncate text-xs text-white/75">{{ $siteName }}</p>
                </div>
            </div>
            <button
                type="button"
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-white/90 transition-colors hover:bg-white/10 hover:text-white"
                @click="open = false"
                aria-label="{{ __('Close') }}"
            >
                <i class="fa-solid fa-xmark text-lg" aria-hidden="true"></i>
            </button>
        </div>
        <div class="border-b border-[#ede9e2] bg-[#faf8f4] px-4 py-3">
            <p class="text-sm leading-snug text-[#3a3a3a]">Për çdo informacion apo kërkesë specifike, agjentët tanë të dedikuar do t'ju ofrojnë asistencë të personalizuar përmes WhatsApp</p>
        </div>
        <div class="p-4">
            <label for="whatsapp-chat-message" class="sr-only">Mesazhi</label>
            <textarea
                id="whatsapp-chat-message"
                x-model="message"
                rows="4"
                maxlength="1000"
                class="w-full resize-none rounded-xl border border-[#e1ddd4] bg-white px-3 py-2.5 text-base text-brand-heading placeholder:text-gray-400 focus:border-brand-light focus:outline-none focus:ring-2 focus:ring-lime-500/25 sm:text-sm"
                placeholder="P.sh. dua informacion për një paketë turistike…"
            ></textarea>
            <button
                type="button"
                @click="sendWhatsApp()"
                class="mt-3 flex w-full items-center justify-center gap-2 rounded-xl bg-brand-btn px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-brand-btn-hover focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-ink focus-visible:ring-offset-2"
            >
                <i class="fa-brands fa-whatsapp text-base" aria-hidden="true"></i>
                <span>Dërgo në WhatsApp</span>
            </button>
        </div>
    </div>

    <button
        type="button"
        @click="toggle()"
        :aria-expanded="open"
        aria-controls="whatsapp-chat-panel"
        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-brand-ink text-white shadow-lg shadow-brand-heading/25 ring-2 ring-white transition hover:bg-brand-heading hover:shadow-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-light focus-visible:ring-offset-2"
        aria-label="Hap bisedën në WhatsApp"
    >
        <i class="fa-solid fa-comments text-xl" x-show="!open" aria-hidden="true"></i>
        <i class="fa-solid fa-chevron-down text-lg" x-show="open" x-cloak aria-hidden="true"></i>
    </button>
</div>
@endif
