<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Tour;
use App\Models\TourCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::where('is_active', true)->with(['category', 'countries', 'images', 'approvedReviews']);

        $countrySlug = $request->input('country') ?: $request->input('city');
        if ($countrySlug) {
            $query->whereHas('countries', fn ($q) => $q->where('slug', $countrySlug));
        }
        if ($request->filled('adults')) {
            $adults = (int) $request->adults;
            if ($adults >= 1) {
                $query->where(function ($q) use ($adults) {
                    $q->whereNull('max_group_size')->orWhere('max_group_size', '>=', $adults);
                });
            }
        }
        if ($request->filled('date')) {
            try {
                $monthStart = Carbon::parse($request->input('date'))->startOfMonth()->startOfDay();
                $monthEnd = $monthStart->copy()->endOfMonth()->endOfDay();
                $monthStartStr = $monthStart->toDateString();
                $monthEndStr = $monthEnd->toDateString();

                $query->where(function ($q) use ($monthStartStr, $monthEndStr, $monthStart, $monthEnd) {
                    $q->where(function ($qCard) use ($monthStartStr, $monthEndStr) {
                        $qCard->whereNotNull('homepage_card_date_from')
                            ->where('homepage_card_date_from', '<=', $monthEndStr)
                            ->whereRaw('COALESCE(homepage_card_date_to, homepage_card_date_from) >= ?', [$monthStartStr]);
                    })->orWhereHas('dates', function ($qDates) use ($monthStart, $monthEnd) {
                        $qDates->where('is_active', true)
                            ->whereDate('date', '>=', $monthStart->toDateString())
                            ->whereDate('date', '<=', $monthEnd->toDateString());
                    });
                });
            } catch (\Throwable) {
                /* invalid date param — ignore */
            }
        }

        if ($request->filled('departure')) {
            try {
                $departureDay = Carbon::parse($request->departure)->startOfDay();
                $departureStr = $departureDay->toDateString();
                $query->where(function ($q) use ($departureStr) {
                    $q->whereDate('homepage_card_date_from', $departureStr)
                        ->orWhereHas('dates', function ($qDates) use ($departureStr) {
                            $qDates->where('is_active', true)
                                ->whereDate('date', $departureStr);
                        });
                });
            } catch (\Throwable) {
                /* invalid departure param — ignore */
            }
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->max_price);
        }
        if ($request->filled('duration')) {
            $durations = is_array($request->duration) ? $request->duration : [$request->duration];
            $query->where(function ($q) use ($durations) {
                foreach ($durations as $d) {
                    $hours = (int) $d;
                    if ($hours > 0) {
                        $q->orWhere('duration_hours', $hours)->orWhere('duration_days', $hours);
                    }
                }
            });
        }
        if ($request->boolean('on_sale')) {
            $query->whereNotNull('base_price')->whereColumn('price', '<', 'base_price');
        }
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(fn ($qry) => $qry->where('title', 'like', "%{$search}%")->orWhere('short_description', 'like', "%{$search}%"));
        }
        if ($request->has('season')) {
            $seasons = array_values(array_filter((array) $request->input('season', [])));
            if (! empty($seasons)) {
                $query->whereIn('season', $seasons);
            }
        }

        $sort = $request->get('sort', 'popular');
        match ($sort) {
            'price_low' => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
            'newest' => $query->orderByDesc('created_at'),
            default => $query->orderByDesc('is_featured')->orderByDesc('created_at'),
        };

        $tours = $query->paginate(12)->withQueryString();
        $categories = TourCategory::orderBy('sort_order')->get();
        $countries = Country::active()->withActiveTours()->orderBy('name')->get();
        $wishlistedIds = auth()->user()?->wishlistTours()->pluck('tours.id')->toArray() ?? [];

        $priceRange = [
            'min' => (int) Tour::where('is_active', true)->min('price'),
            'max' => (int) Tour::where('is_active', true)->max('price'),
        ];

        $seasonOptions = collect([
            ['value' => 'summer', 'label' => __('Summer')],
            ['value' => 'winter', 'label' => __('Winter')],
            ['value' => 'all_season', 'label' => __('All Season')],
        ]);

        return view('pages.tours.index', compact('tours', 'categories', 'countries', 'wishlistedIds', 'priceRange', 'seasonOptions'));
    }

    public function show(string $slug)
    {
        $tour = Tour::where('slug', $slug)->where('is_active', true)
            ->with(['category', 'countries', 'hotels', 'images', 'pricingTiers', 'dates' => fn ($q) => $q->where('is_active', true)->where('date', '>=', now())->orderBy('date')])
            ->withCount(['approvedReviews'])
            ->firstOrFail();

        $tour->load(['itineraries', 'approvedReviews.user']);

        $userHasReviewed = auth()->check()
            ? $tour->reviews()->where('user_id', auth()->id())->exists()
            : false;

        return view('pages.tours.show', compact('tour', 'userHasReviewed'));
    }
}
