<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Event Booking Platform</title>
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>
    <header class="details-header">
        <nav class="navbar">
            <a href="{{ url('/') }}" class="logo">EventBooking</a>

            <div class="nav-links">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ url('/#events') }}">Events</a>
                <a href="{{ route('register') }}" class="nav-button">Register</a>
            </div>
        </nav>
    </header>

    <main class="auth-main">
        <section class="auth-card">
            <span class="eyebrow">Account</span>
            <h1>Login</h1>
            <p>Sign in to reserve tickets and manage your bookings later.</p>

            <form method="POST" action="{{ route('login.store') }}" class="auth-form">
                @csrf

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
                        placeholder="Password"
                        required
                    >

                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <label class="checkbox-row">
                    <input type="checkbox" name="remember" value="1">
                    <span>Remember me</span>
                </label>

                <button type="submit" class="primary-button auth-submit">
                    Login
                </button>
            </form>

            <p class="auth-switch">
                No account yet?
                <a href="{{ route('register') }}">Create an account</a>
            </p>
        </section>
    </main>

    <footer class="site-footer">
        <p>Event Booking Platform. Demo project without real payments.</p>
    </footer>
</body>
</html>