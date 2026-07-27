@extends('admin.layouts.app')

@section('title', 'Admin Profile Settings')
@section('page-title', 'Profile Settings')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Profile Settings</h2>
            <p class="text-muted mb-0">Update your account name, email address, and security password.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary px-4 py-2">
            Back to Dashboard
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-4">

            <!-- Profile Overview Header -->
            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 mb-4">
                <div class="admin-avatar xl bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-3 rounded-circle" style="width: 56px; height: 56px;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">{{ $user->name }}</h5>
                    <p class="text-muted mb-0 small">{{ $user->email }}</p>
                </div>
                <span class="badge bg-primary ms-auto px-3 py-2">System Administrator</span>
            </div>

            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                @method('PUT')

                <!-- Personal Details Section -->
                <h5 class="mb-3 text-primary fw-bold">Personal Details</h5>

                <div class="row g-3 mb-4">
                    <!-- Full Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control form-control-lg fs-6 @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control form-control-lg fs-6 @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <!-- Security & Password Section -->
                <h5 class="mb-1 text-primary fw-bold">Change Password</h5>
                <p class="text-muted small mb-3">Leave blank if you do not wish to change your password.</p>

                <div class="row g-3 mb-4">
                    <!-- Current Password -->
                    <div class="col-md-6">
                        <label for="current_password" class="form-label fw-semibold">Current Password</label>
                        <div class="input-group">
                            <input
                                type="password"
                                name="current_password"
                                id="current_password"
                                class="form-control form-control-lg fs-6 @error('current_password') is-invalid @enderror"
                                placeholder="Enter current password"
                            >
                            <button class="btn btn-outline-secondary px-3 toggle-password-btn" type="button" data-target="current_password" aria-label="Toggle password visibility">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Empty spacer column for equal 2-column alignment -->
                    <div class="col-md-6 d-none d-md-block"></div>

                    <!-- New Password -->
                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold">New Password</label>
                        <div class="input-group">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control form-control-lg fs-6 @error('password') is-invalid @enderror"
                                placeholder="New password"
                            >
                            <button class="btn btn-outline-secondary px-3 toggle-password-btn" type="button" data-target="password" aria-label="Toggle password visibility">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm New Password -->
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label fw-semibold">Confirm New Password</label>
                        <div class="input-group">
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control form-control-lg fs-6"
                                placeholder="Re-enter new password"
                            >
                            <button class="btn btn-outline-secondary px-3 toggle-password-btn" type="button" data-target="password_confirmation" aria-label="Toggle password visibility">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Action Buttons with Equal Sizes -->
                <div class="d-flex align-items-center gap-3 pt-3 border-top">
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold" style="min-width: 180px;">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary px-4 py-2 fw-semibold" style="min-width: 140px;">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection

@push('scripts')
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
@endpush
