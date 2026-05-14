<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event | Event Booking Platform</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>
    <header class="details-header">
        <nav class="navbar">
            <a href="{{ url('/') }}" class="logo">EventBooking</a>

            <div class="nav-links">
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
        <a href="{{ route('admin.events.index') }}" class="back-link">← Back to events</a>

        <section class="admin-form-card">
            <span class="eyebrow">Admin</span>
            <h1>Create event</h1>

            <form method="POST" action="{{ route('admin.events.store') }}" class="admin-form">
                @csrf

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Select category</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required>

                    @error('title')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" required>{{ old('description') }}</textarea>

                    @error('description')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}" required>

                    @error('location')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="event_date">Date</label>
                    <input type="date" id="event_date" name="event_date" value="{{ old('event_date') }}" required>

                    @error('event_date')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" step="0.01" required>

                    @error('price')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="available_tickets">Available tickets</label>
                    <input type="number" id="available_tickets" name="available_tickets" value="{{ old('available_tickets') }}" min="0" required>

                    @error('available_tickets')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="image">Image path</label>
                    <input
                        type="text"
                        id="image"
                        name="image"
                        value="{{ old('image') }}"
                        placeholder="images/events/example.png"
                    >

                    @error('image')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <label class="checkbox-row full-width">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span>Active event</span>
                </label>

                <div class="form-actions full-width">
                    <button type="submit" class="primary-button">Create event</button>
                    <a href="{{ route('admin.events.index') }}" class="reset-link">Cancel</a>
                </div>
            </form>
        </section>
    </main>

    <footer class="site-footer">
        <p>Event Booking Platform. Demo project without real payments.</p>
    </footer>
</body>
</html>