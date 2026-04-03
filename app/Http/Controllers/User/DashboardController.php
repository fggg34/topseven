<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TourEnquiry;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $bookings = $user->bookings()->with(['tour', 'tourDate'])->orderByDesc('created_at')->paginate(10);
        $wishlistTours = $user->wishlistTours()->with(['category', 'images'])->get();
        $activeBookingsCount = $user->bookings()->where('status', '!=', 'cancelled')->count();

        $enquiries = TourEnquiry::query()
            ->with(['tour.images', 'tour'])
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere(function ($q2) use ($user) {
                        $q2->whereNull('user_id')->where('email', $user->email);
                    });
            })
            ->orderByDesc('created_at')
            ->get();

        $enquiriesCount = $enquiries->count();

        return view('dashboard', compact('bookings', 'wishlistTours', 'activeBookingsCount', 'enquiries', 'enquiriesCount'));
    }
}
