<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories | Event Booking Platform</title>
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
                <h1>Manage categories</h1>
            </div>

            <a href="{{ route('admin.categories.create') }}" class="primary-button">
                Add category
            </a>
        </div>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->has('category'))
            <div class="form-error admin-error-box">
                {{ $errors->first('category') }}
            </div>
        @endif

        <section class="admin-panel-card">
            @if ($categories->count() > 0)
                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Events</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ $category->events_count }}</td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="small-edit-button">
                                                Edit
                                            </a>

                                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
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
                    <h3>No categories found</h3>
                    <p>Create the first category for events.</p>
                </div>
            @endif
        </section>
    </main>

    <footer class="site-footer">
        <p>Event Booking Platform. Demo project without real payments.</p>
    </footer>
</body>
</html>