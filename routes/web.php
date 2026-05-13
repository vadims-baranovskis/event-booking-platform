<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $eventsQuery = Event::query()
        ->with('category')
        ->where('is_active', true);

    if ($request->filled('search')) {
        $search = $request->input('search');

        $eventsQuery->where(function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        });
    }

    if ($request->filled('location')) {
        $eventsQuery->where('location', $request->input('location'));
    }

    if ($request->filled('date_from')) {
        $eventsQuery->whereDate('event_date', '>=', $request->input('date_from'));
    }

    if ($request->filled('date_to')) {
        $eventsQuery->whereDate('event_date', '<=', $request->input('date_to'));
    }

    if ($request->filled('price_max')) {
        $eventsQuery->where('price', '<=', $request->input('price_max'));
    }

    $events = $eventsQuery
        ->orderBy('event_date')
        ->get();

    $allEvents = Event::query()
        ->where('is_active', true);

    return view('home', [
        'events' => $events,
        'locations' => Event::query()
            ->where('is_active', true)
            ->select('location')
            ->distinct()
            ->orderBy('location')
            ->pluck('location'),
        'totalEvents' => (clone $allEvents)->count(),
        'totalLocations' => Event::query()
            ->where('is_active', true)
            ->select('location')
            ->distinct()
            ->count('location'),
        'startingPrice' => (clone $allEvents)->min('price'),
    ]);
});

Route::get('/events/{event}', function (Event $event) {
    abort_if(! $event->is_active, 404);

    $event->load('category');

    $relatedEvents = Event::query()
        ->with('category')
        ->where('is_active', true)
        ->where('id', '!=', $event->id)
        ->where('category_id', $event->category_id)
        ->orderBy('event_date')
        ->take(3)
        ->get();

    return view('events.show', [
        'event' => $event,
        'relatedEvents' => $relatedEvents,
    ]);
})->name('events.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::post('/events/{event}/bookings', [BookingController::class, 'store'])
    ->middleware('auth')
    ->name('bookings.store');