<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::with(['user', 'likedBy', 'savedBy'])->latest()->get();

        // Insight of the Day: one random quote, fixed for the whole day
        $dailyId = Cache::remember(
            'daily_quote_' . now()->toDateString(),
            now()->endOfDay(),
            fn () => Quote::inRandomOrder()->value('id')
        );
        $daily = $dailyId ? $quotes->firstWhere('id', $dailyId) : null;

        return view('quotes.index', compact('quotes', 'daily'));
    }

    public function store(StoreQuoteRequest $request)
    {
        $request->user()->quotes()->create($request->validated());

        return redirect()->route('quotes.index');
    }

    public function update(UpdateQuoteRequest $request, Quote $quote)
    {
        $quote->update($request->validated());

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
    public function save(Request $request, Quote $quote)
{
    $request->user()->savedQuotes()->toggle($quote->id);

    return back();
}

public function saved(Request $request)
{
    $quotes = $request->user()->savedQuotes()
        ->with(['user', 'likedBy', 'savedBy'])
        ->latest('saved_quotes.created_at')
        ->get();

    return view('quotes.index', [
        'quotes' => $quotes,
        'daily'  => null,
        'title'  => 'My Insights · مُدْرَكَاتي',
    ]);
}
}