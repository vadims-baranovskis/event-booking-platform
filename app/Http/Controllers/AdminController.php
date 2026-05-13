<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        $latestBookings = Booking::query()
            ->with(['user', 'event'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'totalEvents' => Event::count(),
            'activeEvents' => Event::where('is_active', true)->count(),
            'totalBookings' => Booking::count(),
            'pendingBookings' => Booking::where('status', 'pending')->count(),
            'totalUsers' => User::count(),
            'latestBookings' => $latestBookings,
        ]);
    }
}