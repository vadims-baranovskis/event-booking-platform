<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category | Event Booking Platform</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>
    <header class="details-header">
        <nav class="navbar">
            <a href="{{ url('/') }}" class="logo">EventBooking</a>

            <div class="nav-links">
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
        <a href="{{ route('admin.categories.index') }}" class="back-link">← Back to categories</a>

        <section class="admin-form-card">
            <span class="eyebrow">Admin</span>
            <h1>Edit category</h1>

            <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="admin-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Category name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required>

                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}">

                    @error('slug')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <p class="form-help full-width">
                    If slug is empty, it will be generated automatically from the category name.
                </p>

                <div class="form-actions full-width">
                    <button type="submit" class="primary-button">Save changes</button>
                    <a href="{{ route('admin.categories.index') }}" class="reset-link">Cancel</a>
                </div>
            </form>
        </section>
    </main>

    <footer class="site-footer">
        <p>Event Booking Platform. Demo project without real payments.</p>
    </footer>
</body>
</html>