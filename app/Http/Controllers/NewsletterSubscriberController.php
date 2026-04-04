<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterSubscriberController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'opt_in' => ['nullable', 'boolean'],
        ]);

        NewsletterSubscriber::query()->updateOrCreate(
            ['email' => strtolower(trim((string) $validated['email']))],
            [
                'full_name' => trim((string) ($validated['full_name'] ?? '')) ?: null,
                'opt_in' => (bool) ($validated['opt_in'] ?? false),
                'source' => 'footer',
                'ip_address' => $request->ip(),
            ]
        );

        return back()->with('newsletter_success', __('Thanks for subscribing.'));
    }
}
