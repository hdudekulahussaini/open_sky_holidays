@extends('admin.layouts.app')

@section('title', 'Admin Profile')
@section('page-title', 'Admin Profile Settings')

@section('content')

    <div class="admin-card max-w-4xl mx-auto">

        <div class="admin-card-header">
            <div>
                <h3>Profile Settings</h3>
                <p>Manage your account name, email address, and security password.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.profile.update') }}" class="admin-form">
            @csrf
            @method('PUT')

            <div class="profile-header-banner mb-4">
                <div class="admin-avatar xl">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="profile-header-info">
                    <h4>{{ $user->name }}</h4>
                    <p>{{ $user->email }}</p>
                    <span class="badge bg-primary text-white font-semibold">System Administrator</span>
                </div>
            </div>

            <hr class="my-4">

            <h4 class="form-section-title">Personal Information</h4>

            <div class="admin-form-grid">

                {{-- Name --}}
                <div class="admin-form-group">
                    <label for="name">
                        Full Name
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $user->name) }}"
                        class="admin-form-control @error('name') is-invalid @enderror"
                        required
                    >

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="admin-form-group">
                    <label for="email">
                        Email Address
                        <span class="required">*</span>
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', $user->email) }}"
                        class="admin-form-control @error('email') is-invalid @enderror"
                        required
                    >

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>

            <hr class="my-4">

            <h4 class="form-section-title">Security & Password</h4>

            <p class="form-help-text mb-3">Leave password fields blank if you do not want to change your current password.</p>

            <div class="admin-form-grid">

                {{-- Current Password --}}
                <div class="admin-form-group">
                    <label for="current_password">
                        Current Password
                    </label>

                    <input
                        type="password"
                        name="current_password"
                        id="current_password"
                        class="admin-form-control @error('current_password') is-invalid @enderror"
                        placeholder="Enter current password to verify"
                    >

                    @error('current_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- New Password --}}
                <div class="admin-form-group">
                    <label for="password">
                        New Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="admin-form-control @error('password') is-invalid @enderror"
                        placeholder="Minimum 8 characters"
                    >

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Confirm New Password --}}
                <div class="admin-form-group admin-form-group-full">
                    <label for="password_confirmation">
                        Confirm New Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="admin-form-control"
                        placeholder="Re-enter new password"
                    >
                </div>

            </div>

            <div class="admin-form-actions mt-4">
                <a href="{{ route('admin.dashboard') }}" class="admin-cancel-button">
                    Cancel
                </a>

                <button type="submit" class="admin-submit-button">
                    Save Profile Changes
                </button>
            </div>

        </form>

    </div>

@endsection
