<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Admin Login | Open Sky Holidays</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/admin/images/logo.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">

            <div class="col-11 col-sm-8 col-md-6 col-lg-4">

                <div class="card shadow border-0">
                    <div class="card-body p-4">

                        <div class="text-center mb-4">
                            <img src="{{ asset('assets/admin/images/logo.png') }}" alt="Open Sky Holidays Logo" class="img-fluid mb-2" style="max-height: 60px;">
                            <h2 class="fw-bold fs-4">
                                Admin Login
                            </h2>

                            <p class="text-muted mb-0 small">
                                Open Sky Holidays
                            </p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form
                            method="POST"
                            action="{{ route('admin.login.submit') }}">
                            @csrf

                            <div class="mb-3">
                                <label
                                    for="email"
                                    class="form-label">
                                    Email address
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control"
                                    placeholder="Enter your email"
                                    required
                                    autofocus>
                            </div>

                            <div class="mb-3">
                                <label
                                    for="password"
                                    class="form-label"
                                >
                                    Password
                                </label>

                                <div class="input-group">
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="form-control"
                                        placeholder="Enter your password"
                                        required>
                                    <button
                                        class="btn btn-outline-secondary toggle-password-btn"
                                        type="button"
                                        data-target="password"
                                        aria-label="Toggle password visibility"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input
                                    type="checkbox"
                                    id="remember"
                                    name="remember"
                                    value="1"
                                    class="form-check-input"
                                >

                                <label
                                    for="remember"
                                    class="form-check-label"
                                >
                                    Remember me
                                </label>
                            </div>

                            <div class="d-grid">
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    Login
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButtons = document.querySelectorAll('.toggle-password-btn');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });
        });
    </script>

</body>
</html>