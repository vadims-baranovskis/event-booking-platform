<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $allEvents = collect([
        [
            'title' => "Strūklaku uzvedums 'Zaigo'",
            'category' => 'Culture',
            'date' => '2026-08-03',
            'location' => 'Ogre',
            'price' => 35,
            'available_tickets' => 120,
            'image' => 'images/events/zaigo-ogre.png',
            'description' => 'An evening fountain show with music, lights and a calm summer atmosphere.',
        ],
        [
            'title' => 'Marketing Shake 2026',
            'category' => 'Business',
            'date' => '2026-05-22',
            'location' => 'Rīga',
            'price' => 299,
            'available_tickets' => 80,
            'image' => 'images/events/marketing-shake-2025.png',
            'description' => 'A business and marketing event for people interested in digital growth.',
        ],
        [
            'title' => "Festivāls 'Sniegavīru kāzas'",
            'category' => 'Family',
            'date' => '2026-01-22',
            'location' => 'Rīga',
            'price' => 15,
            'available_tickets' => 200,
            'image' => 'images/events/sniegaviru-kazas.png',
            'description' => 'A winter festival for families with performances, activities and decorations.',
        ],
        [
            'title' => 'WinterCon IX',
            'category' => 'Entertainment',
            'date' => '2026-01-19',
            'location' => 'Rīga',
            'price' => 35,
            'available_tickets' => 150,
            'image' => 'images/events/wintercon-ix.png',
            'description' => 'A convention for fans of games, cosplay, comics and pop culture.',
        ],
        [
            'title' => 'Golden Wines Festival',
            'category' => 'Food',
            'date' => '2026-05-09',
            'location' => 'Rīga',
            'price' => 59,
            'available_tickets' => 95,
            'image' => 'images/events/golden-wines-festival.png',
            'description' => 'A wine tasting festival with selected drinks, food and live atmosphere.',
        ],
        [
            'title' => 'Nordic Kite Fest 2026',
            'category' => 'Sport',
            'date' => '2026-08-01',
            'location' => 'Vilnius',
            'price' => 60,
            'available_tickets' => 180,
            'image' => 'images/events/nordic-kite-fest.png',
            'description' => 'Outdoor kite festival with shows, workshops and activities near the water.',
        ],
        [
            'title' => 'Tallinn Craft Beer Weekend 2026',
            'category' => 'Food',
            'date' => '2026-06-13',
            'location' => 'Tallinn',
            'price' => 135,
            'available_tickets' => 70,
            'image' => 'images/events/tallinn-craft-beer-weekend-2025.png',
            'description' => 'Craft beer event with breweries, tasting sessions and food stands.',
        ],
        [
            'title' => 'Tallinn Rock Festival 2026',
            'category' => 'Music',
            'date' => '2026-06-28',
            'location' => 'Tallinn',
            'price' => 246,
            'available_tickets' => 110,
            'image' => 'images/events/tallinn-rock-festival-2025.png',
            'description' => 'A rock music festival with several bands and a large concert area.',
        ],
        [
            'title' => 'Festivāls Saldus Saule 2026',
            'category' => 'Music',
            'date' => '2026-07-27',
            'location' => 'Saldus',
            'price' => 40,
            'available_tickets' => 220,
            'image' => 'images/events/saldus-saule-2025.png',
            'description' => 'A Latvian music festival with concerts and summer festival atmosphere.',
        ],
        [
            'title' => 'Festivāls Laima RendezVous',
            'category' => 'Music',
            'date' => '2026-07-27',
            'location' => 'Jūrmala',
            'price' => 50,
            'available_tickets' => 130,
            'image' => 'images/events/laima-rendezvous.png',
            'description' => 'A music event in Jūrmala with popular performers and a summer mood.',
        ],
        [
            'title' => 'Õllesummer 2026',
            'category' => 'Music',
            'date' => '2026-07-30',
            'location' => 'Tallinn',
            'price' => 70,
            'available_tickets' => 160,
            'image' => 'images/events/ollesummer-2025.png',
            'description' => 'A summer festival with music, food, drinks and entertainment areas.',
        ],
    ]);

    $events = $allEvents;

    if ($request->filled('search')) {
        $search = mb_strtolower($request->input('search'));

        $events = $events->filter(function ($event) use ($search) {
            return str_contains(mb_strtolower($event['title']), $search)
                || str_contains(mb_strtolower($event['description']), $search);
        });
    }

    if ($request->filled('location')) {
        $events = $events->where('location', $request->input('location'));
    }

    if ($request->filled('date_from')) {
        $events = $events->filter(function ($event) use ($request) {
            return $event['date'] >= $request->input('date_from');
        });
    }

    if ($request->filled('date_to')) {
        $events = $events->filter(function ($event) use ($request) {
            return $event['date'] <= $request->input('date_to');
        });
    }

    if ($request->filled('price_max')) {
        $events = $events->filter(function ($event) use ($request) {
            return $event['price'] <= (float) $request->input('price_max');
        });
    }

    return view('home', [
        'events' => $events->values(),
        'locations' => $allEvents->pluck('location')->unique()->sort()->values(),
        'totalEvents' => $allEvents->count(),
        'totalLocations' => $allEvents->pluck('location')->unique()->count(),
        'startingPrice' => $allEvents->min('price'),
    ]);
});