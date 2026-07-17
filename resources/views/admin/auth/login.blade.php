<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Admin Login | Open Sky Holidays</title>

    <!-- Google Fonts: Rubik -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.css') }}">
</head>

<body class="login-body">
    <div class="login-card">
        <h1>Open Sky Holidays</h1>

        <p class="subtitle">
            Login to the administration panel
        </p>

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('admin.login.submit') }}"
        >
            @csrf

            <div class="form-group">
                <label for="email">
                    Email address
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >
            </div>

            <label class="remember-row">
                <input
                    type="checkbox"
                    name="remember"
                    value="1"
                >

                Remember me
            </label>

            <button
                type="submit"
                class="login-button"
            >
                Login
            </button>
        </form>
    </div>
    <script src="{{ asset('assets/admin/js/admin.js') }}"></script>
</body>
</html>