<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()
            ->bookings()
            ->with(['event.category'])
            ->latest()
            ->get();

        return view('bookings.index', [
            'bookings' => $bookings,
        ]);
    }

    public function store(Request $request, Event $event)
    {
        abort_if(! $event->is_active, 404);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = (int) $validated['quantity'];

        if ($event->event_date->isPast()) {
            return back()->withErrors([
                'quantity' => 'You cannot book tickets for a past event.',
            ]);
        }

        if ($quantity > $event->available_tickets) {
            return back()->withErrors([
                'quantity' => 'Not enough tickets available.',
            ]);
        }

        DB::transaction(function () use ($event, $quantity) {
            $lockedEvent = Event::where('id', $event->id)
                ->lockForUpdate()
                ->first();

            if ($quantity > $lockedEvent->available_tickets) {
                throw new \Exception('Not enough tickets available.');
            }

            Booking::create([
                'user_id' => auth()->id(),
                'event_id' => $lockedEvent->id,
                'quantity' => $quantity,
                'total_price' => $lockedEvent->price * $quantity,
                'status' => 'pending',
            ]);

            $lockedEvent->decrement('available_tickets', $quantity);
        });

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Tickets reserved successfully. Booking status: pending.');
    }

    public function cancel(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);

        if ($booking->status === 'cancelled') {
            return back()->with('success', 'Booking is already cancelled.');
        }

        DB::transaction(function () use ($booking) {
            $booking->load('event');

            $booking->update([
                'status' => 'cancelled',
            ]);

            $booking->event->increment('available_tickets', $booking->quantity);
        });

        return back()->with('success', 'Booking cancelled successfully.');
    }
}