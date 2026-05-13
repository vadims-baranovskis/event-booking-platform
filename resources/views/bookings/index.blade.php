<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings | Event Booking Platform</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>
    <header class="details-header">
        <nav class="navbar">
            <a href="{{ url('/') }}" class="logo">EventBooking</a>

            <div class="nav-links">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ url('/#events') }}">Events</a>

                @auth
                    <a href="{{ route('bookings.index') }}">My bookings</a>

                    <span class="user-badge">{{ auth()->user()->name }}</span>

                    @if (auth()->user()->role === 'admin')
                        <span class="role-badge">Admin</span>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="nav-button logout-button">Logout</button>
                    </form>
                @endauth
            </div>
        </nav>
    </header>

    <main class="bookings-main">
        <div class="section-heading">
            <span class="eyebrow">Account</span>
            <h1>My bookings</h1>
        </div>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if ($bookings->count() > 0)
            <div class="bookings-list">
                @foreach ($bookings as $booking)
                    <article class="booking-card">
                        <div class="booking-image">
                            <img src="{{ asset($booking->event->image) }}" alt="{{ $booking->event->title }}">
                        </div>

                        <div class="booking-content">
                            <div class="event-meta">
                                <span>{{ $booking->event->category->name }}</span>
                                <span>{{ $booking->event->event_date->format('d.m.Y') }}</span>
                            </div>

                            <h2>{{ $booking->event->title }}</h2>

                            <p>
                                {{ $booking->event->location }}
                            </p>

                            <div class="booking-details-grid">
                                <div>
                                    <span>Quantity</span>
                                    <strong>{{ $booking->quantity }}</strong>
                                </div>

                                <div>
                                    <span>Total price</span>
                                    <strong>€{{ number_format($booking->total_price, 0) }}</strong>
                                </div>

                                <div>
                                    <span>Status</span>
                                    <strong class="status-badge status-{{ $booking->status }}">
                                        {{ ucfirst($booking->status) }}
                                    </strong>
                                </div>
                            </div>

                            <div class="booking-actions">
                                <a href="{{ route('events.show', $booking->event) }}" class="card-button">
                                    View event
                                </a>

                                @if ($booking->status !== 'cancelled')
                                    <form method="POST" action="{{ route('bookings.cancel', $booking) }}">
                                        @csrf
                                        <button type="submit" class="cancel-button">
                                            Cancel booking
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <h3>No bookings yet</h3>
                <p>You have not reserved any tickets yet.</p>
                <a href="{{ url('/#events') }}" class="primary-button">Browse events</a>
            </div>
        @endif
    </main>

    <footer class="site-footer">
        <p>Event Booking Platform. Demo project without real payments.</p>
    </footer>
</body>
</html>