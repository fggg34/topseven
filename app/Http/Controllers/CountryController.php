<?php

namespace App\Http\Controllers;

use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::query()
            ->active()
            ->withActiveTours()
            ->withCount(['tours' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('name')
            ->get();

        return view('pages.countries.index', compact('countries'));
    }

    public function show(string $slug)
    {
        $country = Country::where('slug', $slug)
            ->with([
                'highlights',
                'tours' => fn ($q) => $q->where('is_active', true)->with(['images', 'category', 'approvedReviews']),
            ])
            ->firstOrFail();

        $wishlistedIds = auth()->user()?->wishlistTours()->pluck('tours.id')->toArray() ?? [];

        return view('pages.countries.show', compact('country', 'wishlistedIds'));
    }
}
