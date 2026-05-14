<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events | Event Booking Platform</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>
    <header class="details-header">
        <nav class="navbar">
            <a href="{{ url('/') }}" class="logo">EventBooking</a>

            <div class="nav-links">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ route('admin.dashboard') }}">Admin panel</a>
                <a href="{{ route('admin.events.index') }}">Events</a>
                <a href="{{ route('admin.bookings.index') }}">Bookings</a>

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
        <div class="admin-panel-header">
            <div>
                <span class="eyebrow">Admin</span>
                <h1>Manage events</h1>
            </div>

            <a href="{{ route('admin.events.create') }}" class="primary-button">
                Add event
            </a>
        </div>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <section class="admin-panel-card">
            @if ($events->count() > 0)
                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Price</th>
                                <th>Tickets</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td>
                                        <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" class="admin-event-thumb">
                                    </td>
                                    <td>{{ $event->title }}</td>
                                    <td>{{ $event->category->name }}</td>
                                    <td>{{ $event->event_date->format('d.m.Y') }}</td>
                                    <td>{{ $event->location }}</td>
                                    <td>€{{ number_format($event->price, 0) }}</td>
                                    <td>{{ $event->available_tickets }}</td>
                                    <td>
                                        @if ($event->is_active)
                                            <span class="status-badge status-confirmed">Active</span>
                                        @else
                                            <span class="status-badge status-cancelled">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="{{ route('admin.events.edit', $event) }}" class="small-edit-button">
                                                Edit
                                            </a>

                                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="small-delete-button">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <h3>No events found</h3>
                    <p>Create your first event for the catalog.</p>
                </div>
            @endif
        </section>
    </main>

    <footer class="site-footer">
        <p>Event Booking Platform. Demo project without real payments.</p>
    </footer>
</body>
</html>