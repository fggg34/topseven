<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Country;
use App\Models\HomepageHero;
use App\Models\Review;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourPackage;

class HomeController extends Controller
{
    public function __invoke()
    {
        $hero = HomepageHero::getActive();
        $countries = Country::active()->with(['tours' => fn ($q) => $q->where('is_active', true)->select('id', 'price')])->orderBy('name')->get();

        $featuredTours = Tour::where('is_active', true)->where('is_featured', true)
            ->with(['category', 'images', 'approvedReviews'])
            ->orderBy('sort_order')
            ->limit(12)
            ->get();

        $wishlistedIds = auth()->user()?->wishlistTours()->pluck('tours.id')->toArray() ?? [];

        $destinationCountries = Country::active()
            ->whereHas('tours', fn ($q) => $q->where('is_active', true))
            ->withCount(['tours' => fn ($q) => $q->where('is_active', true)])
            ->with(['tours' => fn ($q) => $q->where('is_active', true)])
            ->orderByDesc('tours_count')
            ->limit(12)
            ->get();

        if ($destinationCountries->isEmpty()) {
            $destinationCountries = Country::active()
                ->with(['tours' => fn ($q) => $q->where('is_active', true)])
                ->orderBy('name')
                ->limit(12)
                ->get();
        }

        $categories = TourCategory::orderBy('sort_order')->get();

        $homepageCategories = TourCategory::whereIn('slug', ['day-tours', 'multi-day-tours'])
            ->orderBy('sort_order')
            ->with(['tours' => fn ($q) => $q->where('is_active', true)->with(['images', 'approvedReviews', 'category'])->orderBy('sort_order')->limit(12)])
            ->get();

        if ($homepageCategories->count() < 2) {
            $homepageCategories = TourCategory::orderBy('sort_order')
                ->limit(2)
                ->with(['tours' => fn ($q) => $q->where('is_active', true)->with(['images', 'approvedReviews', 'category'])->orderBy('sort_order')->limit(12)])
                ->get();
        }

        $homepageCategories = $homepageCategories
            ->filter(fn (TourCategory $category) => $category->tours->isNotEmpty())
            ->values();

        $latestPosts = BlogPost::where('is_published', true)
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->limit(4)
            ->get();

        $testimonials = Review::where('is_approved', true)
            ->whereNotNull('comment')
            ->where('comment', '!=', '')
            ->with('user')
            ->latest()
            ->limit(12)
            ->get();

        $totalReviews = Review::where('is_approved', true)->count();

        $tourPackages = TourPackage::visibleOnHome()
            ->orderBy('sort_order')
            ->get();

        return view('pages.home', compact('hero', 'countries', 'featuredTours', 'wishlistedIds', 'destinationCountries', 'categories', 'homepageCategories', 'latestPosts', 'testimonials', 'totalReviews', 'tourPackages'));
    }
}
