<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::with(['user', 'likedBy'])->latest()->get();

        return view('quotes.index', compact('quotes'));
    }

    public function store(Request $request)
    {
       $validated = $request->validate([
    'text' => ['required', 'string', 'min:3', 'max:155'],
    'mood' => ['required', 'in:' . implode(',', array_keys(Quote::MOODS))],
]);

        $request->user()->quotes()->create($validated);

        return redirect()->route('quotes.index');
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