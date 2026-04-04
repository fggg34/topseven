<?php

namespace App\Http\Controllers;

use App\Models\TourEnquiry;
use Illuminate\Http\Request;

class TourEnquiryController extends Controller
{
    public function store(Request $request, string $tourSlug)
    {
        $tour = \App\Models\Tour::where('slug', $tourSlug)->firstOrFail();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => ['nullable', 'string', 'max:24'],
            'guests' => 'required|integer|min:1|max:100',
            'message' => 'nullable|string|max:2000',
        ]);

        $phone = isset($validated['phone']) ? trim((string) $validated['phone']) : '';
        $phone = $phone !== '' ? $phone : null;

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
