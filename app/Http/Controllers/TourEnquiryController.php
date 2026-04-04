<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\TourEnquiry;
use Illuminate\Http\Request;

class TourEnquiryController extends Controller
{
    public function store(Request $request, string $tourSlug)
    {
        $tour = \App\Models\Tour::where('slug', $tourSlug)->firstOrFail();

        $usesDialList = Country::query()
            ->whereNotNull('calling_code')
            ->whereNotNull('iso_alpha2')
            ->exists();

        $phone = null;

        if ($usesDialList) {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone_country' => ['nullable', 'required_with:phone_national', 'string', 'size:2', 'regex:/^[A-Za-z]{2}$/'],
                'phone_national' => ['nullable', 'string', 'max:32', 'regex:/^[\d\s\-\(\)]*$/'],
                'guests' => 'required|integer|min:1|max:100',
                'message' => 'nullable|string|max:2000',
            ]);

            $nationalDigits = isset($validated['phone_national'])
                ? preg_replace('/\D+/', '', $validated['phone_national'])
                : '';

            if ($nationalDigits !== '') {
                $iso = strtoupper((string) ($validated['phone_country'] ?? ''));
                $dial = $iso !== ''
                    ? Country::query()->where('iso_alpha2', $iso)->value('calling_code')
                    : null;
                $phone = $dial ? '+'.$dial.' '.$nationalDigits : $nationalDigits;
            }
        } else {
            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:50',
                'guests' => 'required|integer|min:1|max:100',
                'message' => 'nullable|string|max:2000',
            ]);
            $phone = $validated['phone'] ?? null;
        }

        TourEnquiry::create([
            'tour_id' => $tour->id,
            'user_id' => auth()->id(),
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $phone,
            'departure_date' => $tour->homepage_card_date_from,
            'return_date' => $tour->homepage_card_date_to,
            'guests' => $validated['guests'],
            'message' => $validated['message'] ?? null,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('enquiry_success', 'Thank you! Your enquiry has been submitted. We will get back to you shortly.');
    }
}
