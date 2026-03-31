<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Highlight;

class HighlightController extends Controller
{
    public function show(string $country, string $highlight)
    {
        $country = Country::where('slug', $country)->firstOrFail();
        $highlight = Highlight::where('slug', $highlight)->firstOrFail();

        if (! $country->highlights->contains($highlight)) {
            abort(404);
        }

        $otherHighlights = $country->highlights()
            ->where('highlights.id', '!=', $highlight->id)
            ->orderByPivot('sort_order')
            ->get();

        return view('pages.highlights.show', [
            'country' => $country,
            'highlight' => $highlight,
            'otherHighlights' => $otherHighlights,
        ]);
    }
}
