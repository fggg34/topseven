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
            'phone' => 'nullable|string|max:50',
            'departure_date' => 'nullable|date',
            'return_date' => 'nullable|date',
            'guests' => 'required|integer|min:1|max:100',
            'message' => 'nullable|string|max:2000',
        ]);

        TourEnquiry::create([
            'tour_id' => $tour->id,
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'departure_date' => $validated['departure_date'] ?? null,
            'return_date' => $validated['return_date'] ?? null,
            'guests' => $validated['guests'],
            'message' => $validated['message'] ?? null,
            'ip_address' => $request->ip(),
        ]);

        return back()->with('enquiry_success', 'Thank you! Your enquiry has been submitted. We will get back to you shortly.');
    }
}
