<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\HomepageHero;
use App\Models\HomepageSecondarySpotlightTour;
use App\Models\HomepageSpotlightTour;
use App\Models\HomepageWhyBookCard;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Tour;

class HomeController extends Controller
{
    public function __invoke()
    {
        $heroSlides = HomepageHero::query()
            ->where('is_active', true)
            ->orderByDesc('updated_at')
            ->get();

        $homepageFlashSaleTours = HomepageSpotlightTour::query()
            ->with([
                'tour' => fn ($q) => $q
                    ->where('is_active', true)
                    ->with(['images', 'countries', 'category']),
            ])
            ->orderBy('sort_order')
            ->get()
            ->filter(fn (HomepageSpotlightTour $row) => $row->tour !== null)
            ->values();
        $countries = Country::active()->with(['tours' => fn ($q) => $q->where('is_active', true)->select('id', 'price')])->orderBy('name')->get();
        $homepageFlashSaleToursSecondary = HomepageSecondarySpotlightTour::query()
            ->with([
                'tour' => fn ($q) => $q
                    ->where('is_active', true)
                    ->with(['images', 'countries', 'category']),
            ])
            ->orderBy('sort_order')
            ->get()
            ->filter(fn (HomepageSecondarySpotlightTour $row) => $row->tour !== null)
            ->values();

        $featuredTours = Tour::where('is_active', true)->where('is_featured', true)
            ->with(['category', 'images', 'approvedReviews'])
            ->orderBy('sort_order')
            ->limit(12)
            ->get();

        $wishlistedIds = auth()->user()?->wishlistTours()->pluck('tours.id')->toArray() ?? [];

        $whereNextCountries = Country::active()
            ->whereHas('tours', fn ($q) => $q->where('is_active', true))
            ->withCount(['tours' => fn ($q) => $q->where('is_active', true)])
            ->orderByDesc('tours_count')
            ->limit(10)
            ->get();

        if ($whereNextCountries->isEmpty()) {
            $whereNextCountries = Country::active()
                ->withCount(['tours' => fn ($q) => $q->where('is_active', true)])
                ->orderByDesc('tours_count')
                ->limit(10)
                ->get();
        }

        $whyBookHeading = Setting::get('homepage_why_book_heading', 'Why thousands book with us.');
        $whyBookCards = HomepageWhyBookCard::query()->orderBy('sort_order')->get();
        $homepageReviews = Review::query()
            ->where('is_approved', true)
            ->with([
                'user:id,name',
                'tour:id,title',
            ])
            ->orderByDesc('review_date')
            ->orderByDesc('id')
            ->limit(12)
            ->get();

        return view('pages.home', compact('heroSlides', 'homepageFlashSaleTours', 'homepageFlashSaleToursSecondary', 'countries', 'featuredTours', 'wishlistedIds', 'whereNextCountries', 'whyBookHeading', 'whyBookCards', 'homepageReviews'));
    }
}
