<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBookingController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(auth()->user()->role === 'admin', 403);
    }

    public function index()
    {
        $this->ensureAdmin();

        $bookings = Booking::query()
            ->with(['user', 'event.category'])
            ->latest()
            ->get();

        return view('admin.bookings.index', [
            'bookings' => $bookings,
        ]);
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled'],
        ]);

        DB::transaction(function () use ($booking, $validated) {
            $booking->load('event');

            $oldStatus = $booking->status;
            $newStatus = $validated['status'];

            if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
                $booking->event->increment('available_tickets', $booking->quantity);
            }

            if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
                if ($booking->quantity > $booking->event->available_tickets) {
                    throw new \Exception('Not enough tickets available to reactivate this booking.');
                }

                $booking->event->decrement('available_tickets', $booking->quantity);
            }

            $booking->update([
                'status' => $newStatus,
            ]);
        });

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking status updated successfully.');
    }
}