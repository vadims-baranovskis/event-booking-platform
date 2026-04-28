<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Booking Platform</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>
    <header class="site-header">
        <nav class="navbar">
            <a href="{{ url('/') }}" class="logo">EventBooking</a>

            <div class="nav-links">
                <a href="#events">Events</a>
                <a href="#filters">Search</a>
                <a href="#" class="nav-button">Login</a>
            </div>
        </nav>

        <section class="hero">
            <div class="hero-content">
                <span class="eyebrow">Demo Laravel project</span>
                <h1>Find events and reserve tickets online</h1>
                <p>
                    A portfolio project for browsing events, filtering by location and price,
                    and later booking tickets through a simple user account.
                </p>

                <div class="hero-actions">
                    <a href="#events" class="primary-button">Browse events</a>
                    <a href="#filters" class="secondary-button">Search tickets</a>
                </div>
            </div>

            <div class="hero-card">
                <p class="hero-card-label">Featured event</p>
                <h2>Tallinn Rock Festival</h2>
                <p>Large summer rock festival with tickets, categories and booking logic.</p>
                <div class="hero-price">from €246</div>
            </div>
        </section>
    </header>

    <main>
        <section class="stats-section">
            <div class="stat-card">
                <span>{{ $totalEvents }}</span>
                <p>Events</p>
            </div>

            <div class="stat-card">
                <span>{{ $totalLocations }}</span>
                <p>Locations</p>
            </div>

            <div class="stat-card">
                <span>€{{ $startingPrice }}</span>
                <p>Starting price</p>
            </div>
        </section>

        <section id="filters" class="filter-section">
            <div class="section-heading">
                <span class="eyebrow">Search</span>
                <h2>Find the right event</h2>
            </div>

            <form method="GET" action="{{ url('/') }}" class="filter-form">
                <div class="form-group">
                    <label for="search">Event name</label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by name"
                    >
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <select id="location" name="location">
                        <option value="">All locations</option>

                        @foreach ($locations as $location)
                            <option value="{{ $location }}" @selected(request('location') === $location)>
                                {{ $location }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="date_from">Date from</label>
                    <input
                        type="date"
                        id="date_from"
                        name="date_from"
                        value="{{ request('date_from') }}"
                    >
                </div>

                <div class="form-group">
                    <label for="date_to">Date to</label>
                    <input
                        type="date"
                        id="date_to"
                        name="date_to"
                        value="{{ request('date_to') }}"
                    >
                </div>

                <div class="form-group">
                    <label for="price_max">Max price</label>
                    <input
                        type="number"
                        id="price_max"
                        name="price_max"
                        value="{{ request('price_max') }}"
                        min="0"
                        placeholder="300"
                    >
                </div>

                <div class="filter-actions">
                    <button type="submit" class="primary-button">Apply filters</button>
                    <a href="{{ url('/') }}" class="reset-link">Reset</a>
                </div>
            </form>
        </section>

        <section id="events" class="events-section">
            <div class="section-heading">
                <span class="eyebrow">Available tickets</span>
                <h2>Upcoming events</h2>
            </div>

            <div class="events-grid">
                @forelse ($events as $event)
                    <article class="event-card">
                        <img src="{{ asset($event['image']) }}" alt="{{ $event['title'] }}">

                        <div class="event-card-body">
                            <div class="event-meta">
                                <span>{{ $event['category'] }}</span>
                                <span>{{ \Carbon\Carbon::parse($event['date'])->format('d.m.Y') }}</span>
                            </div>

                            <h3>{{ $event['title'] }}</h3>

                            <p class="event-description">
                                {{ $event['description'] }}
                            </p>

                            <div class="event-info">
                                <span>{{ $event['location'] }}</span>
                                <span>{{ $event['available_tickets'] }} tickets left</span>
                            </div>

                            <div class="event-footer">
                                <strong>€{{ $event['price'] }}</strong>
                                <a href="#" class="card-button">View details</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="empty-state">
                        <h3>No events found</h3>
                        <p>Try changing your filters or resetting the search form.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <p>Event Booking Platform. Demo project without real payments.</p>
    </footer>
</body>
</html>