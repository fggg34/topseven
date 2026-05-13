<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\TourEnquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

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

        $to = Setting::siteNotificationEmail();
        if ($to === '') {
            throw ValidationException::withMessages([
                'email' => [__('Enquiries are not configured. Please try again later or contact us directly.')],
            ]);
        }

        $tourUrl = route('tours.show', $tour->slug, absolute: true);
        $departure = $tour->homepage_card_date_from?->toDateString() ?? '—';
        $return = $tour->homepage_card_date_to?->toDateString() ?? '—';
        $msg = trim((string) ($validated['message'] ?? ''));
        $msg = $msg !== '' ? $msg : '—';

        $body = implode("\n", [
            'New tour enquiry.',
            '',
            'Tour: '.$tour->title,
            'Tour URL: '.$tourUrl,
            '',
            'Full name: '.$validated['full_name'],
            'Email: '.$validated['email'],
            'Phone: '.($phone ?? '—'),
            'Guests: '.$validated['guests'],
            'Package departure (from tour): '.$departure,
            'Package return (from tour): '.$return,
            '',
            'Message:',
            $msg,
            '',
            'IP: '.$request->ip(),
        ]);

        try {
            DB::transaction(function () use ($tour, $validated, $phone, $request, $to, $body) {
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

                Mail::raw(
                    $body,
                    fn ($m) => $m->to($to)->subject('Tour enquiry: '.$tour->title)
                );
            });
        } catch (\Throwable $e) {
            Log::error('Tour enquiry mail failed', ['exception' => $e->getMessage(), 'tour_id' => $tour->id]);

            throw ValidationException::withMessages([
                'email' => [__('Unable to submit enquiry. Please try again or contact us directly.')],
            ]);
        }

        return back()->with('enquiry_success', __('Thank you! Your enquiry has been submitted. We will get back to you shortly.'));
    }
}
