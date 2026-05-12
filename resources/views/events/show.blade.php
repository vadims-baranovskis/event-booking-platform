<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} | Event Booking Platform</title>
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
        <span class="user-badge">{{ auth()->user()->name }}</span>

        @if (auth()->user()->role === 'admin')
            <span class="role-badge">Admin</span>
        @endif

        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="nav-button logout-button">Logout</button>
        </form>
    @else
        <a href="{{ route('login') }}" class="nav-button">Login</a>
        <a href="{{ route('register') }}" class="nav-button">Register</a>
    @endauth
</div>
        </nav>
    </header>

    <main class="details-main">
        <a href="{{ url('/#events') }}" class="back-link">← Back to events</a>

        <section class="event-details-layout">
            <div class="event-details-image">
                <img src="{{ asset($event->image) }}" alt="{{ $event->title }}">
            </div>

            <div class="event-details-content">
                <span class="eyebrow">{{ $event->category->name }}</span>

                <h1>{{ $event->title }}</h1>

                <p class="details-description">
                    {{ $event->description }}
                </p>

                <div class="details-info-grid">
                    <div class="details-info-card">
                        <span>Date</span>
                        <strong>{{ $event->event_date->format('d.m.Y') }}</strong>
                    </div>

                    <div class="details-info-card">
                        <span>Location</span>
                        <strong>{{ $event->location }}</strong>
                    </div>

                    <div class="details-info-card">
                        <span>Price</span>
                        <strong>€{{ number_format($event->price, 0) }}</strong>
                    </div>

                    <div class="details-info-card">
                        <span>Available tickets</span>
                        <strong>{{ $event->available_tickets }}</strong>
                    </div>
                </div>

                <div class="booking-preview-card">
                    <h2>Reserve tickets</h2>
                    <p>
                        Ticket reservation will be available after user authentication is added.
                        This project does not process real payments.
                    </p>

                    <div class="booking-preview-form">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="quantity" value="1" min="1" max="{{ $event->available_tickets }}" disabled>
                        <button class="primary-button" disabled>Booking coming soon</button>
                    </div>
                </div>
            </div>
        </section>

        @if ($relatedEvents->count() > 0)
            <section class="related-events-section">
                <div class="section-heading">
                    <span class="eyebrow">Related</span>
                    <h2>Similar events</h2>
                </div>

                <div class="events-grid">
                    @foreach ($relatedEvents as $relatedEvent)
                        <article class="event-card">
                            <img src="{{ asset($relatedEvent->image) }}" alt="{{ $relatedEvent->title }}">

                            <div class="event-card-body">
                                <div class="event-meta">
                                    <span>{{ $relatedEvent->category->name }}</span>
                                    <span>{{ $relatedEvent->event_date->format('d.m.Y') }}</span>
                                </div>

                                <h3>{{ $relatedEvent->title }}</h3>

                                <p class="event-description">
                                    {{ $relatedEvent->description }}
                                </p>

                                <div class="event-footer">
                                    <strong>€{{ number_format($relatedEvent->price, 0) }}</strong>
                                    <a href="{{ route('events.show', $relatedEvent) }}" class="card-button">View details</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </main>

    <footer class="site-footer">
        <p>Event Booking Platform. Demo project without real payments.</p>
    </footer>
</body>
</html>