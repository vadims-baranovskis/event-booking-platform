<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Event Booking Platform</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>
    <header class="details-header">
        <nav class="navbar">
            <a href="{{ url('/') }}" class="logo">EventBooking</a>

            <div class="nav-links">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ url('/#events') }}">Events</a>
                <a href="{{ route('login') }}" class="nav-button">Login</a>
            </div>
        </nav>
    </header>

    <main class="auth-main">
        <section class="auth-card">
            <span class="eyebrow">Account</span>
            <h1>Create account</h1>
            <p>Create a demo user account to use ticket reservation features later.</p>

            <form method="POST" action="{{ route('register.store') }}" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Your name"
                        required
                    >

                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="user@example.com"
                        required
                    >

                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="At least 6 characters"
                        required
                    >

                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Repeat password"
                        required
                    >
                </div>

                <button type="submit" class="primary-button auth-submit">
                    Register
                </button>
            </form>

            <p class="auth-switch">
                Already have an account?
                <a href="{{ route('login') }}">Login</a>
            </p>
        </section>
    </main>

    <footer class="site-footer">
        <p>Event Booking Platform. Demo project without real payments.</p>
    </footer>
</body>
</html>