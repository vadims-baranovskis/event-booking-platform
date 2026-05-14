<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings | Event Booking Platform</title>
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
                <a href="{{ route('admin.categories.index') }}">Categories</a>
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
                <h1>Manage bookings</h1>
            </div>
        </div>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="form-error admin-error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <section class="admin-panel-card">
            @if ($bookings->count() > 0)
                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Event</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Current status</th>
                                <th>Created</th>
                                <th>Change status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>
                                        <strong>{{ $booking->user->name }}</strong><br>
                                        <span class="table-muted">{{ $booking->user->email }}</span>
                                    </td>

                                    <td>{{ $booking->event->title }}</td>
                                    <td>{{ $booking->event->category->name }}</td>
                                    <td>{{ $booking->quantity }}</td>
                                    <td>€{{ number_format($booking->total_price, 0) }}</td>

                                    <td>
                                        <span class="status-badge status-{{ $booking->status }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>

                                    <td>{{ $booking->created_at->format('d.m.Y H:i') }}</td>

                                    <td>
                                        <form method="POST" action="{{ route('admin.bookings.update-status', $booking) }}" class="status-form">
                                            @csrf
                                            @method('PUT')

                                            <select name="status">
                                                <option value="pending" @selected($booking->status === 'pending')>
                                                    Pending
                                                </option>

                                                <option value="confirmed" @selected($booking->status === 'confirmed')>
                                                    Confirmed
                                                </option>

                                                <option value="cancelled" @selected($booking->status === 'cancelled')>
                                                    Cancelled
                                                </option>
                                            </select>

                                            <button type="submit" class="small-edit-button">
                                                Save
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <h3>No bookings found</h3>
                    <p>User bookings will appear here after ticket reservations.</p>
                </div>
            @endif
        </section>
    </main>

    <footer class="site-footer">
        <p>Event Booking Platform. Demo project without real payments.</p>
    </footer>
</body>
</html>