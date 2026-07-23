@extends('admin.layouts.app')

@section('title', 'Edit Tour Inquiry')
@section('page-title', 'Edit Tour Inquiry')

@section('content')

    <div class="admin-card">

        <div class="admin-card-header">
            <div>
                <a href="{{ route('admin.tour-inquiries.index') }}" class="back-link">
                    ← Back to Tour Inquiries
                </a>
                <h3>Edit Inquiry #{{ $tourInquiry->id }}</h3>
                <p>
                    Update the contact details, travel date, number of travelers, or current workflow status.
                </p>
            </div>
        </div>

        <form
            method="POST"
            action="{{ route('admin.tour-inquiries.update', $tourInquiry) }}"
            class="admin-form"
            style="max-width: 800px; margin-top: 20px;"
        >
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-12">
                    <label>Selected Tour</label>
                    <input
                        type="text"
                        value="{{ $tourInquiry->tour ? $tourInquiry->tour->title : 'N/A' }}"
                        disabled
                        class="form-control"
                        style="background: #f5f5f5;"
                    >
                </div>
            </div>

            <div class="form-row" style="display: flex; gap: 16px; margin-bottom: 16px;">
                <div class="form-group" style="flex: 1;">
                    <label for="name">Customer Name <span class="required">*</span></label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $tourInquiry->name) }}"
                        required
                    >
                    @error('name')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" style="flex: 1;">
                    <label for="phone">Mobile Number <span class="required">*</span></label>
                    <input
                        type="text"
                        name="phone"
                        id="phone"
                        value="{{ old('phone', $tourInquiry->phone) }}"
                        required
                    >
                    @error('phone')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row" style="display: flex; gap: 16px; margin-bottom: 16px;">
                <div class="form-group" style="flex: 1;">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', $tourInquiry->email) }}"
                        required
                    >
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" style="flex: 1;">
                    <label for="travel_date">Travel Date <span class="required">*</span></label>
                    <input
                        type="date"
                        name="travel_date"
                        id="travel_date"
                        value="{{ old('travel_date', $tourInquiry->travel_date ? $tourInquiry->travel_date->format('Y-m-d') : '') }}"
                        required
                    >
                    @error('travel_date')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row" style="display: flex; gap: 16px; margin-bottom: 16px;">
                <div class="form-group" style="flex: 1;">
                    <label for="travelers">Number of Travelers <span class="required">*</span></label>
                    <input
                        type="number"
                        name="travelers"
                        id="travelers"
                        min="1"
                        value="{{ old('travelers', $tourInquiry->travelers) }}"
                        required
                    >
                    @error('travelers')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" style="flex: 1;">
                    <label for="status">Status <span class="required">*</span></label>
                    <select name="status" id="status" required>
                        <option value="new" @selected(old('status', $tourInquiry->status) === 'new')>New</option>
                        <option value="contacted" @selected(old('status', $tourInquiry->status) === 'contacted')>Contacted</option>
                        <option value="closed" @selected(old('status', $tourInquiry->status) === 'closed')>Closed</option>
                    </select>
                    @error('status')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions" style="margin-top: 24px;">
                <button type="submit" class="btn btn-primary">
                    Save Changes
                </button>
                <a href="{{ route('admin.tour-inquiries.index') }}" class="btn btn-light">
                    Cancel
                </a>
            </div>

        </form>

    </div>

@endsection
