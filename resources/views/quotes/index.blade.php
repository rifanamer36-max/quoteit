@extends('layouts.tuwaiq')

@section('title', 'إدراك!')

@section('content')
<div class="mx-auto max-w-3xl p-4 pb-28 sm:p-8 sm:pb-28" x-data="quotesPage({{ $errors->any() ? 'true' : 'false' }})">

    @if ($daily)
        <x-daily-insight :quote="$daily" />
    @endif

    <x-calm-banner :quotes="$quotes" />

    <h2 class="mb-4 text-2xl font-bold text-white">{{ $title ?? 'Quotes' }}</h2>

    <div class="relative mb-4">
        <input type="search" x-model="search" placeholder="Search quotes or authors… ابحث في الاقتباسات"
               class="input pl-10">
        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2">🔍</span>
    </div>

    <x-mood-filter />

    @guest
        <a href="{{ route('login') }}" class="btn-primary mb-6">Log in to share a quote</a>
    @endguest

    <div class="flex flex-col gap-4">
        @forelse ($quotes as $quote)
            <x-quote-card :quote="$quote" :delay="min($loop->index, 8) * 60" />
        @empty
            <p class="text-gray-300">{{ isset($title) ? "You haven't saved any insights yet." : 'No quotes yet. Be the first to share one!' }}</p>
        @endforelse
    </div>

    @auth
        <x-share-modal />
    @endauth

    <x-card-modal />
    <x-focus-overlay />
</div>
@endsection