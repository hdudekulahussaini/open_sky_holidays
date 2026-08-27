<div class="row g-4">

    {{-- Contact Information Details --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3 p-4" style="background: #ffffff;">
            <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                <i class="fa-solid fa-address-book text-primary fs-5"></i>
                <h5 class="mb-0 fw-bold">Contact &amp; Location Details</h5>
            </div>

            <div class="row g-4">
                {{-- Phone Number --}}
                <div class="col-md-6">
                    <label for="phone" class="form-label fw-semibold">
                        <i class="fa-solid fa-phone text-primary me-1"></i> Phone Number
                    </label>
                    <input type="text" name="phone" id="phone"
                        class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', $contactSection->phone ?? '+91 99081 17712') }}"
                        placeholder="e.g. +91 99081 17712">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email Address --}}
                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold">
                        <i class="fa-solid fa-envelope text-warning me-1"></i> Email Address
                    </label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $contactSection->email ?? 'info@openskyholidays.com') }}"
                        placeholder="e.g. info@openskyholidays.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- WhatsApp Number --}}
                <div class="col-md-6">
                    <label for="whatsapp_number" class="form-label fw-semibold">
                        <i class="fa-brands fa-whatsapp text-success me-1"></i> WhatsApp Number
                    </label>
                    <input type="text" name="whatsapp_number" id="whatsapp_number"
                        class="form-control @error('whatsapp_number') is-invalid @enderror"
                        value="{{ old('whatsapp_number', $contactSection->whatsapp_number ?? '+91 99081 17712') }}"
                        placeholder="e.g. +91 99081 17712">
                    @error('whatsapp_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Google Maps URL --}}
                <div class="col-md-6">
                    <label for="map_link" class="form-label fw-semibold">
                        <i class="fa-solid fa-map-location-dot text-danger me-1"></i> Google Maps URL ("View On Map" Link)
                    </label>
                    <input type="text" name="map_link" id="map_link"
                        class="form-control @error('map_link') is-invalid @enderror"
                        value="{{ old('map_link', $contactSection->map_link ?? 'https://www.google.com/maps/search/?api=1&query=Shyamlal+Building+Begumpet+Hyderabad+500018') }}"
                        placeholder="https://www.google.com/maps/search/?api=1&query=...">
                    @error('map_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Address --}}
                <div class="col-12">
                    <label for="address" class="form-label fw-semibold">
                        <i class="fa-solid fa-location-dot text-danger me-1"></i> Office Address
                    </label>
                    <textarea name="address" id="address" rows="3"
                        class="form-control @error('address') is-invalid @enderror"
                        placeholder="e.g. #1-11-110, Shyamlal Building, Begumpet, Hyderabad - 500018">{{ old('address', $contactSection->address ?? '#1-11-110, Shyamlal Building, Begumpet, Hyderabad - 500018') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Map Embed URL --}}
                <div class="col-12">
                    <label for="map_embed_url" class="form-label fw-semibold">
                        <i class="fa-solid fa-map text-info me-1"></i> Map Embed URL / Iframe src (Optional)
                    </label>
                    <input type="text" name="map_embed_url" id="map_embed_url"
                        class="form-control @error('map_embed_url') is-invalid @enderror"
                        value="{{ old('map_embed_url', $contactSection->map_embed_url ?? '') }}"
                        placeholder="https://maps.google.com/maps?q=Begumpet&output=embed">
                    <small class="text-muted">Optional: If provided, frontend can render an interactive Google Map iframe.</small>
                    @error('map_embed_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Status / Visibility --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3 p-4" style="background: #ffffff;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-1 fw-bold">Active Status</h6>
                    <p class="text-muted small mb-0">Enable or disable this contact info on the public website API.</p>
                </div>
                <div class="form-check form-switch fs-4">
                    <input type="checkbox" name="status" id="status" class="form-check-input" value="1"
                        {{ old('status', $contactSection->status ?? true) ? 'checked' : '' }}>
                </div>
            </div>
        </div>
    </div>

</div>
