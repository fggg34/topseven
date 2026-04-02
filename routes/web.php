<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\HighlightController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterSubscriberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TourController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/sitemap.xml', \App\Http\Controllers\SitemapController::class)->name('sitemap');

Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
// More specific tour routes first so /tours/{slug} doesn't capture e.g. slug "xyz/available-dates"
Route::get('/tours/{slug}/price', [\App\Http\Controllers\Api\TourBookingApiController::class, 'price'])->name('tours.price');
Route::get('/tours/{slug}/available-dates', [\App\Http\Controllers\Api\TourBookingApiController::class, 'availableDates'])->name('tours.available-dates');
Route::get('/tours/{slug}/check-date', [\App\Http\Controllers\Api\TourBookingApiController::class, 'checkDate'])->name('tours.check-date');
Route::get('/tours/{slug}/book', [\App\Http\Controllers\BookingController::class, 'create'])->name('bookings.create');
Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours.show');

Route::get('/countries', [CountryController::class, 'index'])->name('countries.index');
Route::get('/countries/{country}/highlights/{highlight}', [HighlightController::class, 'show'])->name('countries.highlights.show');
Route::get('/countries/{slug}', [CountryController::class, 'show'])->name('countries.show');

Route::permanentRedirect('/cities', '/countries');
Route::permanentRedirect('/cities/{slug}', '/countries/{slug}');
Route::get('/cities/{city}/highlights/{highlight}', function (string $city, string $highlight) {
    return redirect()->route('countries.highlights.show', ['country' => $city, 'highlight' => $highlight], 301);
});

Route::post('/bookings', [\App\Http\Controllers\BookingController::class, 'store'])->middleware('throttle:10,1')->name('bookings.store');
Route::post('/tours/{slug}/enquiry', [\App\Http\Controllers\TourEnquiryController::class, 'store'])->middleware('throttle:10,1')->name('tours.enquiry.store');
Route::get('/bookings/confirmation/{token}', [\App\Http\Controllers\BookingController::class, 'confirmation'])->name('bookings.confirmation');

Route::permanentRedirect('/packages', '/tours');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/about', AboutController::class)->name('about');
Route::get('/faq', fn () => view('pages.faq'))->name('faq');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

Route::post('/newsletter', [NewsletterSubscriberController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('newsletter.subscribe');

Route::get('/dashboard', \App\Http\Controllers\User\DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/my-bookings/{token}/cancel', [\App\Http\Controllers\User\BookingController::class, 'cancelByToken'])->name('user.bookings.cancel');
    Route::post('/wishlist/{tour}', [\App\Http\Controllers\User\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{tour}', [\App\Http\Controllers\User\WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/tours/{tour:slug}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
});

require __DIR__.'/auth.php';
