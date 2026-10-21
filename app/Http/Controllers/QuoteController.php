<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;

class QuoteController extends Controller
{
    public function index()
{
    $quotes = Quote::with(['user', 'likedBy'])->latest()->get();

    // Insight of the Day: one random quote, fixed for the whole day
    $dailyId = Cache::remember(
        'daily_quote_' . now()->toDateString(),
        now()->endOfDay(),
        fn () => Quote::inRandomOrder()->value('id')
    );
    $daily = $dailyId ? $quotes->firstWhere('id', $dailyId) : null;

    return view('quotes.index', compact('quotes', 'daily'));
}

    public function update(Request $request, Quote $quote)
    {
        Gate::authorize('update', $quote);

        $validated = $request->validateWithBag('update', [
            'text' => ['required', 'string', 'min:3', 'max:155'],
        ]);

        $quote->update($validated);

        return redirect()->route('quotes.index');
    }

    public function destroy(Quote $quote)
    {
        Gate::authorize('delete', $quote);

        $quote->delete();

        return redirect()->route('quotes.index');
    }

    public function like(Request $request, Quote $quote)
    {
        $quote->likedBy()->toggle($request->user()->id);

        return back();
    }
}