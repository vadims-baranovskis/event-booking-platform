<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Event Booking Platform</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>
    <header class="details-header">
        <nav class="navbar">
            <a href="{{ url('/') }}" class="logo">EventBooking</a>

            <div class="nav-links">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ url('/#events') }}">Events</a>
                <a href="{{ route('bookings.index') }}">My bookings</a>

                <span class="user-badge">{{ auth()->user()->name }}</span>
                <span class="role-badge">Admin</span>

                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="nav-button logout-button">Logout</button>
                </form>
            </div>
        </nav>
    </header>

    <main class="admin-main">
        <div class="section-heading">
            <span class="eyebrow">Admin</span>
            <h1>Dashboard</h1>
        </div>

        <section class="admin-stats-grid">
            <article class="admin-stat-card">
                <span>{{ $totalEvents }}</span>
                <p>Total events</p>
            </article>

            <article class="admin-stat-card">
                <span>{{ $activeEvents }}</span>
                <p>Active events</p>
            </article>

            <article class="admin-stat-card">
                <span>{{ $totalBookings }}</span>
                <p>Total bookings</p>
            </article>

            <article class="admin-stat-card">
                <span>{{ $pendingBookings }}</span>
                <p>Pending bookings</p>
            </article>

            <article class="admin-stat-card">
                <span>{{ $totalUsers }}</span>
                <p>Users</p>
            </article>
        </section>

        <section class="admin-panel-card">
            <div class="admin-panel-header">
                <div>
                    <span class="eyebrow">Overview</span>
                    <h2>Latest bookings</h2>
                </div>
            </div>

            @if ($latestBookings->count() > 0)
                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Event</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($latestBookings as $booking)
                                <tr>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>{{ $booking->event->title }}</td>
                                    <td>{{ $booking->quantity }}</td>
                                    <td>€{{ number_format($booking->total_price, 0) }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $booking->status }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $booking->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <h3>No bookings yet</h3>
                    <p>Latest user bookings will appear here.</p>
                </div>
            @endif
        </section>

        <section class="admin-actions-grid">
            <article class="admin-action-card">
                <h3>Event management</h3>
                <p>Create, edit and delete events.</p>
                <span class="disabled-link">Coming next</span>
            </article>

            <article class="admin-action-card">
                <h3>Category management</h3>
                <p>Create and update event categories.</p>
                <span class="disabled-link">Coming later</span>
            </article>

            <article class="admin-action-card">
                <h3>Booking management</h3>
                <p>Confirm or cancel user bookings.</p>
                <span class="disabled-link">Coming later</span>
            </article>
        </section>
    </main>

    <footer class="site-footer">
        <p>Event Booking Platform. Demo project without real payments.</p>
    </footer>
</body>
</html>