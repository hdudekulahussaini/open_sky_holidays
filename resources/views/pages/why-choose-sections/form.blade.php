@php
    $categories = [
        'all' => 'All Icons',
        'popular' => 'Featured',
        'travel' => 'Tours & Travel',
        'trust' => 'Trust & Quality',
        'support' => 'Support & Safety',
    ];

    $curatedIcons = [
        // Featured (Matching User Website)
        ['class' => 'fa-solid fa-earth-americas', 'name' => 'Worldwide Coverage', 'cat' => 'popular', 'tag' => 'globe world earth domestic international coverage'],
        ['class' => 'fa-solid fa-bolt-lightning', 'name' => 'Value For Money', 'cat' => 'popular', 'tag' => 'lightning bolt fast budget instant money value'],
        ['class' => 'fa-solid fa-calendar-check', 'name' => 'Fast Booking', 'cat' => 'popular', 'tag' => 'booking calendar ticket schedule fast reservation'],
        ['class' => 'fa-solid fa-person-hiking', 'name' => 'Customized Tours', 'cat' => 'popular', 'tag' => 'tours hiking guide adventure custom packages'],
        ['class' => 'fa-solid fa-headset', 'name' => 'Complete Support 24/7', 'cat' => 'popular', 'tag' => 'support 24/7 headset help call center assistance team'],
        ['class' => 'fa-solid fa-shield-halved', 'name' => 'Safe & Flexible Travel', 'cat' => 'popular', 'tag' => 'shield safe flexible security protection safety'],

        // Tours, Travel & Destinations
        ['class' => 'fa-solid fa-globe', 'name' => 'Global Network', 'cat' => 'travel', 'tag' => 'globe network world international destination'],
        ['class' => 'fa-solid fa-plane-departure', 'name' => 'Flight Bookings', 'cat' => 'travel', 'tag' => 'plane flight airport travel departure airline'],
        ['class' => 'fa-solid fa-map-location-dot', 'name' => 'Custom Destinations', 'cat' => 'travel', 'tag' => 'map location pin destination route place'],
        ['class' => 'fa-solid fa-route', 'name' => 'Tailored Itineraries', 'cat' => 'travel', 'tag' => 'route path trip plan roadmap journey'],
        ['class' => 'fa-solid fa-compass', 'name' => 'Expert Guides', 'cat' => 'travel', 'tag' => 'compass guide direction exploration explore'],
        ['class' => 'fa-solid fa-mountain-sun', 'name' => 'Mountain & Nature', 'cat' => 'travel', 'tag' => 'mountain sun hill nature trekking hill station'],
        ['class' => 'fa-solid fa-umbrella-beach', 'name' => 'Beach & Resort', 'cat' => 'travel', 'tag' => 'beach island summer holiday resort tropical'],
        ['class' => 'fa-solid fa-hotel', 'name' => 'Luxury Stays', 'cat' => 'travel', 'tag' => 'hotel stay accommodation room booking resort villa'],
        ['class' => 'fa-solid fa-car', 'name' => 'Transport & Transfers', 'cat' => 'travel', 'tag' => 'car vehicle transport transfer cab taxi bus'],
        ['class' => 'fa-solid fa-ticket', 'name' => 'Tour Passes & Tickets', 'cat' => 'travel', 'tag' => 'ticket pass entry coupon admission event'],
        ['class' => 'fa-solid fa-suitcase-rolling', 'name' => 'Hassle-Free Luggage', 'cat' => 'travel', 'tag' => 'luggage suitcase baggage travel trip bag'],
        ['class' => 'fa-solid fa-passport', 'name' => 'Visa Assistance', 'cat' => 'travel', 'tag' => 'passport visa document embassy travel immigration'],

        // Value, Trust & Excellence
        ['class' => 'fa-solid fa-hand-holding-dollar', 'name' => 'Best Price Guarantee', 'cat' => 'trust', 'tag' => 'money price cheap afford cost guarantee discount'],
        ['class' => 'fa-solid fa-tags', 'name' => 'Special Offers', 'cat' => 'trust', 'tag' => 'tags offer discount promo deal sales bargain'],
        ['class' => 'fa-solid fa-percent', 'name' => 'Best Discounts', 'cat' => 'trust', 'tag' => 'percent discount offer cheap budget deal'],
        ['class' => 'fa-solid fa-star', 'name' => '5-Star Experience', 'cat' => 'trust', 'tag' => 'star quality premium top rating review luxury'],
        ['class' => 'fa-solid fa-award', 'name' => 'Certified & Trusted', 'cat' => 'trust', 'tag' => 'award badge certificate trust winner quality'],
        ['class' => 'fa-solid fa-medal', 'name' => 'Top Rated Agency', 'cat' => 'trust', 'tag' => 'medal champion award rank #1 best'],
        ['class' => 'fa-solid fa-thumbs-up', 'name' => '100% Satisfaction', 'cat' => 'trust', 'tag' => 'satisfaction happy like thumbsup guarantee positive'],
        ['class' => 'fa-solid fa-heart', 'name' => 'Customer Care', 'cat' => 'trust', 'tag' => 'heart love care customer satisfaction friendly'],

        // Support & Safety
        ['class' => 'fa-solid fa-clock-rotate-left', 'name' => '24/7 Availability', 'cat' => 'support', 'tag' => 'clock 24/7 time round clock history always'],
        ['class' => 'fa-solid fa-phone-volume', 'name' => 'Instant Call Helpline', 'cat' => 'support', 'tag' => 'phone call contact hotline dial emergency'],
        ['class' => 'fa-solid fa-comments', 'name' => 'Live Chat Support', 'cat' => 'support', 'tag' => 'chat comments message message support talk'],
        ['class' => 'fa-solid fa-user-shield', 'name' => 'Verified Partners', 'cat' => 'support', 'tag' => 'user shield partner verified safe security partner'],
        ['class' => 'fa-solid fa-lock', 'name' => 'Secure Payments', 'cat' => 'support', 'tag' => 'lock secure payment card safety checkout'],
        ['class' => 'fa-solid fa-notes-medical', 'name' => 'Travel Insurance', 'cat' => 'support', 'tag' => 'medical insurance safety health emergency doctor'],
    ];

    $currentIcon = old('icon', $whyChooseSection->icon ?? 'fa-solid fa-earth-americas');
    $currentTitle = old('title', $whyChooseSection->title ?? 'Worldwide Coverage');
    $currentDesc = old('description', $whyChooseSection->description ?? 'Explore domestic and international destinations with complete planning and trusted travel support.');
@endphp

<style>
/* Modern Luxury Form Theme for Why Choose Us */
.wc-form-wrapper {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 1.75rem;
    align-items: start;
}

@media (max-width: 1024px) {
    .wc-form-wrapper {
        grid-template-columns: 1fr;
    }
}

.wc-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    margin-bottom: 1.5rem;
    transition: all 0.25s ease;
}

.wc-card-header {
    padding: 1.25rem 1.5rem;
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.wc-card-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin: 0;
}

.wc-card-title i {
    color: #0284c7;
    font-size: 1.1rem;
}

.wc-card-body {
    padding: 1.5rem;
}

/* Category Filter Tabs */
.wc-cat-tabs {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px dashed #e2e8f0;
}

.wc-cat-pill {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid transparent;
    border-radius: 20px;
    padding: 0.35rem 0.9rem;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.wc-cat-pill:hover {
    background: #e2e8f0;
    color: #0f172a;
}

.wc-cat-pill.is-active {
    background: #0284c7;
    color: #ffffff;
    box-shadow: 0 3px 8px rgba(2, 132, 199, 0.3);
}

/* Clickable Icon Cards Grid */
.wc-icon-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 0.75rem;
    max-height: 320px;
    overflow-y: auto;
    padding: 0.75rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
}

.wc-icon-grid::-webkit-scrollbar {
    width: 6px;
}

.wc-icon-grid::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.wc-icon-item {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.85rem 0.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    text-align: center;
    outline: none;
}

.wc-icon-item:hover {
    transform: translateY(-2px);
    border-color: #38bdf8;
    box-shadow: 0 6px 14px rgba(2, 132, 199, 0.12);
}

.wc-icon-item .wc-icon-graphic {
    font-size: 1.5rem;
    color: #334155;
    transition: all 0.2s ease;
}

.wc-icon-item .wc-icon-name {
    font-size: 0.75rem;
    font-weight: 600;
    color: #475569;
    line-height: 1.25;
}

.wc-icon-item.is-selected {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border-color: #0284c7;
    box-shadow: 0 4px 12px rgba(2, 132, 199, 0.2);
}

.wc-icon-item.is-selected .wc-icon-graphic {
    color: #0284c7;
    transform: scale(1.1);
}

.wc-icon-item.is-selected .wc-icon-name {
    color: #0369a1;
}

.wc-icon-check {
    position: absolute;
    top: 5px;
    right: 5px;
    background: #0284c7;
    color: #ffffff;
    width: 17px;
    height: 17px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
    font-weight: bold;
    box-shadow: 0 2px 4px rgba(2, 132, 199, 0.3);
}

/* Frontend Live Simulator Card */
.wc-preview-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 1.75rem;
    box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.07);
    display: flex;
    gap: 1.25rem;
    align-items: flex-start;
    position: relative;
    transition: all 0.3s ease;
}

.wc-preview-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 16px 35px -5px rgba(0, 0, 0, 0.1);
}

.wc-preview-icon-box {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border: 1.5px solid #bae6fd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.65rem;
    color: #0284c7;
    flex-shrink: 0;
    box-shadow: 0 4px 10px rgba(2, 132, 199, 0.15);
}

.wc-preview-content h4 {
    font-size: 1.15rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 0.45rem 0;
    line-height: 1.3;
}

.wc-preview-content p {
    font-size: 0.88rem;
    color: #64748b;
    line-height: 1.55;
    margin: 0;
}
</style>

<div class="wc-form-wrapper">

    {{-- Main Column (Left) --}}
    <div class="wc-main-col">

        {{-- Content Card --}}
        <div class="wc-card">
            <div class="wc-card-header">
                <h3 class="wc-card-title">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Section Content
                </h3>
                <span style="font-size: 0.78rem; background: #e0f2fe; color: #0369a1; padding: 0.25rem 0.65rem; border-radius: 20px; font-weight: 600;">Step 1</span>
            </div>

            <div class="wc-card-body">
                {{-- Title --}}
                <div class="admin-form-group full-width mb-3">
                    <label for="title" class="fw-bold mb-1" style="font-size: 0.92rem; color: #1e293b;">
                        Title <span class="required" style="color: #ef4444;">*</span>
                    </label>

                    <input type="text" name="title" id="title" class="admin-form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $whyChooseSection->title ?? '') }}" placeholder="e.g. Worldwide Coverage, Fast Booking, 24/7 Support..."
                        style="height: 48px; border-radius: 10px; font-size: 0.95rem; font-weight: 500;"
                        required>

                    @error('title')
                        <span class="admin-form-error" style="color: #ef4444; font-size: 0.82rem; margin-top: 0.25rem; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="admin-form-group full-width mb-0">
                    <label for="description" class="fw-bold mb-1" style="font-size: 0.92rem; color: #1e293b;">
                        Description <span class="required" style="color: #ef4444;">*</span>
                    </label>

                    <textarea name="description" id="description" rows="4"
                        class="admin-form-control @error('description') is-invalid @enderror"
                        placeholder="e.g. Explore domestic and international destinations with complete planning and trusted travel support."
                        style="border-radius: 10px; font-size: 0.92rem; line-height: 1.5; padding: 0.75rem;"
                        required>{{ old('description', $whyChooseSection->description ?? '') }}</textarea>

                    @error('description')
                        <span class="admin-form-error" style="color: #ef4444; font-size: 0.82rem; margin-top: 0.25rem; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Icon Studio Card --}}
        <div class="wc-card">
            <div class="wc-card-header">
                <h3 class="wc-card-title">
                    <i class="fa-solid fa-icons"></i>
                    Feature Icon Studio
                </h3>
                <span style="font-size: 0.78rem; background: #e0f2fe; color: #0369a1; padding: 0.25rem 0.65rem; border-radius: 20px; font-weight: 600;">Step 2</span>
            </div>

            <div class="wc-card-body">
                
                {{-- Search & Custom Input Bar --}}
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 1rem; margin-bottom: 1.25rem; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
                    <div style="display: flex; gap: 0.85rem; align-items: center; flex-wrap: wrap;">
                        
                        {{-- Active Badge --}}
                        <div style="display: flex; align-items: center; gap: 0.75rem; background: #f0f9ff; border: 1.5px solid #0284c7; border-radius: 10px; padding: 0.4rem 0.85rem; flex-shrink: 0;">
                            <div id="iconBadgeBox" style="width: 38px; height: 38px; border-radius: 8px; background: #ffffff; border: 1px solid #bae6fd; display: flex; align-items: center; justify-content: center; font-size: 1.35rem; color: #0284c7;">
                                <i id="iconBadgeIcon" class="{{ $currentIcon ?: 'fa-solid fa-earth-americas' }}"></i>
                            </div>
                            <div>
                                <span style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px; color: #0284c7; font-weight: 700; display: block;">Active Icon</span>
                                <strong id="iconBadgeName" style="font-size: 0.88rem; color: #0f172a; white-space: nowrap;">Worldwide Coverage</strong>
                            </div>
                        </div>

                        {{-- Search Filter Input --}}
                        <div style="flex: 1; min-width: 200px; position: relative;">
                            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                            <input type="text" id="iconSearchInput" class="admin-form-control"
                                   placeholder="Search icons (globe, ticket, plane, money, support...)"
                                   style="padding-left: 2.3rem; height: 42px; border-radius: 10px; font-size: 0.88rem;">
                        </div>

                        {{-- Direct FontAwesome Class Input --}}
                        <div style="width: 220px;">
                            <input type="text" name="icon" id="iconInput"
                                class="admin-form-control @error('icon') is-invalid @enderror"
                                value="{{ $currentIcon }}"
                                placeholder="fa-solid fa-..."
                                style="height: 42px; border-radius: 10px; font-size: 0.88rem; font-family: monospace;"
                                title="FontAwesome 6 Icon Class">
                        </div>
                    </div>
                </div>

                {{-- Category Filter Tabs --}}
                <div class="wc-cat-tabs">
                    @foreach($categories as $catKey => $catLabel)
                        <button type="button" class="wc-cat-pill js-cat-btn {{ $catKey === 'all' ? 'is-active' : '' }}" data-cat="{{ $catKey }}">
                            {{ $catLabel }}
                        </button>
                    @endforeach
                </div>

                {{-- Interactive Icon Grid --}}
                <div class="wc-icon-grid" id="iconGridContainer">
                    @foreach($curatedIcons as $item)
                        @php
                            $isSelected = ($currentIcon === $item['class']);
                        @endphp
                        <button type="button"
                                class="wc-icon-item js-icon-card {{ $isSelected ? 'is-selected' : '' }}"
                                data-icon-class="{{ $item['class'] }}"
                                data-icon-name="{{ $item['name'] }}"
                                data-icon-cat="{{ $item['cat'] }}"
                                data-icon-tags="{{ $item['tag'] }}">
                            <div class="wc-icon-graphic">
                                <i class="{{ $item['class'] }}"></i>
                            </div>
                            <span class="wc-icon-name">
                                {{ $item['name'] }}
                            </span>
                            @if($isSelected)
                                <span class="wc-icon-check">✓</span>
                            @endif
                        </button>
                    @endforeach
                </div>

                <div id="noIconsFound" style="display: none; text-align: center; padding: 2rem 1rem; color: #64748b;">
                    <i class="fa-solid fa-circle-question fs-3 mb-2 d-block text-muted"></i>
                    <p class="mb-0 fw-semibold">No matching icons found</p>
                    <small>Type any custom FontAwesome class in the input box above.</small>
                </div>

                @error('icon')
                    <span class="admin-form-error" style="color: #ef4444; font-size: 0.82rem; margin-top: 0.5rem; display: block;">
                        {{ $message }}
                    </span>
                @enderror

            </div>
        </div>

    </div>

    {{-- Sidebar Column (Right) --}}
    <div class="wc-sidebar-col">

        {{-- Live Frontend Preview Card --}}
        <div class="wc-card" style="border-color: #bae6fd; background: linear-gradient(180deg, #f0f9ff 0%, #ffffff 100%);">
            <div class="wc-card-header" style="background: transparent; border-color: #e0f2fe;">
                <h3 class="wc-card-title" style="color: #0369a1;">
                    <i class="fa-solid fa-eye" style="color: #0284c7;"></i>
                    Website Card Preview
                </h3>
                <span style="font-size: 0.72rem; text-transform: uppercase; background: #0284c7; color: #fff; padding: 0.2rem 0.5rem; border-radius: 6px; font-weight: 700; letter-spacing: 0.5px;">Live</span>
            </div>

            <div class="wc-card-body p-3">
                <p class="text-muted small mb-3" style="font-size: 0.8rem;">
                    This is an exact preview of how this benefit card appears to travelers on your website:
                </p>

                {{-- Visual Card Replica --}}
                <div class="wc-preview-card">
                    <div class="wc-preview-icon-box">
                        <i id="previewCardIcon" class="{{ $currentIcon ?: 'fa-solid fa-earth-americas' }}"></i>
                    </div>
                    <div class="wc-preview-content">
                        <h4 id="previewCardTitle">{{ $currentTitle ?: 'Worldwide Coverage' }}</h4>
                        <p id="previewCardDesc">{{ $currentDesc ?: 'Explore domestic and international destinations with complete planning and trusted travel support.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Publishing & Settings Card --}}
        <div class="wc-card">
            <div class="wc-card-header">
                <h3 class="wc-card-title">
                    <i class="fa-solid fa-sliders"></i>
                    Publishing Settings
                </h3>
            </div>

            <div class="wc-card-body">
                
                {{-- Status --}}
                <div class="mb-3">
                    <label for="status" class="fw-bold mb-1" style="font-size: 0.9rem; color: #1e293b;">
                        Status <span class="required" style="color: #ef4444;">*</span>
                    </label>

                    <select id="status" name="status" class="admin-form-control @error('status') is-invalid @enderror"
                            style="height: 44px; border-radius: 10px; font-size: 0.9rem;" required>
                        <option value="1" @selected(old('status', $whyChooseSection->status ?? 1) == 1)>
                            ● Active (Published on website)
                        </option>
                        <option value="0" @selected(old('status', $whyChooseSection->status ?? 1) == 0)>
                            ○ Inactive (Hidden from website)
                        </option>
                    </select>

                    @error('status')
                        <span class="admin-form-error" style="color: #ef4444; font-size: 0.82rem; margin-top: 0.25rem; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Sort Order --}}
                <div class="mb-4">
                    <label for="sort_order" class="fw-bold mb-1" style="font-size: 0.9rem; color: #1e293b;">
                        Display Sort Order <span class="required" style="color: #ef4444;">*</span>
                    </label>

                    <input type="number" name="sort_order" id="sort_order" min="0"
                        class="admin-form-control @error('sort_order') is-invalid @enderror"
                        value="{{ old('sort_order', $whyChooseSection->sort_order ?? 0) }}"
                        style="height: 44px; border-radius: 10px; font-size: 0.9rem;"
                        placeholder="0 = First" required>
                    <small class="text-muted d-block mt-1" style="font-size: 0.78rem;">Lower numbers appear first on the home page.</small>

                    @error('sort_order')
                        <span class="admin-form-error" style="color: #ef4444; font-size: 0.82rem; margin-top: 0.25rem; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div style="display: flex; flex-direction: column; gap: 0.65rem;">
                    <button type="submit" class="btn btn-primary w-100" style="height: 46px; border-radius: 10px; font-weight: 600; font-size: 0.95rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);">
                        <i class="fa-solid fa-floppy-disk"></i>
                        {{ $buttonText ?? 'Save Section' }}
                    </button>

                    <a href="{{ route('admin.why-choose-sections.index') }}" class="btn btn-light w-100 text-center" style="height: 42px; border-radius: 10px; font-weight: 500; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; border: 1px solid #e2e8f0; color: #64748b;">
                        Cancel
                    </a>
                </div>

            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const titleInput = document.getElementById('title');
    const descInput = document.getElementById('description');
    const iconInput = document.getElementById('iconInput');
    const iconSearchInput = document.getElementById('iconSearchInput');
    const iconBadgeIcon = document.getElementById('iconBadgeIcon');
    const iconBadgeName = document.getElementById('iconBadgeName');
    const previewCardTitle = document.getElementById('previewCardTitle');
    const previewCardDesc = document.getElementById('previewCardDesc');
    const previewCardIcon = document.getElementById('previewCardIcon');
    const iconCards = document.querySelectorAll('.js-icon-card');
    const catBtns = document.querySelectorAll('.js-cat-btn');
    const noIconsFound = document.getElementById('noIconsFound');

    let currentCategory = 'all';

    // Update live frontend simulator
    if (titleInput) {
        titleInput.addEventListener('input', function () {
            previewCardTitle.textContent = this.value.trim() || 'Worldwide Coverage';
        });
    }

    if (descInput) {
        descInput.addEventListener('input', function () {
            previewCardDesc.textContent = this.value.trim() || 'Explore domestic and international destinations with complete planning and trusted travel support.';
        });
    }

    function setSelectedIcon(cls, name) {
        if (!cls || cls.trim() === '') {
            cls = 'fa-solid fa-question';
            name = 'Custom Icon';
        }

        iconInput.value = cls;
        iconBadgeIcon.className = cls;
        previewCardIcon.className = cls;
        iconBadgeName.textContent = name || cls;

        // Highlight active card
        iconCards.forEach(card => {
            const cardClass = card.getAttribute('data-icon-class');
            const isMatch = (cardClass === cls);
            let checkEl = card.querySelector('.wc-icon-check');

            if (isMatch) {
                card.classList.add('is-selected');
                if (!checkEl) {
                    checkEl = document.createElement('span');
                    checkEl.className = 'wc-icon-check';
                    checkEl.textContent = '✓';
                    card.appendChild(checkEl);
                }
            } else {
                card.classList.remove('is-selected');
                if (checkEl) checkEl.remove();
            }
        });
    }

    // Click on icon card
    iconCards.forEach(card => {
        card.addEventListener('click', function () {
            const cls = this.getAttribute('data-icon-class');
            const name = this.getAttribute('data-icon-name');
            setSelectedIcon(cls, name);
        });
    });

    // Custom class typing
    if (iconInput) {
        iconInput.addEventListener('input', function () {
            const val = this.value.trim();
            let matchedName = 'Custom Icon';
            iconCards.forEach(card => {
                if (card.getAttribute('data-icon-class') === val) {
                    matchedName = card.getAttribute('data-icon-name');
                }
            });
            setSelectedIcon(val, matchedName);
        });
    }

    // Category Tabs Filtering
    catBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            catBtns.forEach(b => b.classList.remove('is-active'));
            this.classList.add('is-active');
            currentCategory = this.getAttribute('data-cat');
            filterIcons();
        });
    });

    // Search Filtering
    if (iconSearchInput) {
        iconSearchInput.addEventListener('input', function () {
            filterIcons();
        });
    }

    function filterIcons() {
        const q = (iconSearchInput ? iconSearchInput.value : '').toLowerCase().trim();
        let visibleCount = 0;

        iconCards.forEach(card => {
            const name = (card.getAttribute('data-icon-name') || '').toLowerCase();
            const cls = (card.getAttribute('data-icon-class') || '').toLowerCase();
            const tags = (card.getAttribute('data-icon-tags') || '').toLowerCase();
            const cat = card.getAttribute('data-icon-cat');

            const matchCat = (currentCategory === 'all' || cat === currentCategory);
            const matchSearch = (!q || name.includes(q) || cls.includes(q) || tags.includes(q));

            if (matchCat && matchSearch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noIconsFound) {
            noIconsFound.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    // Initialize labels
    const initCls = iconInput.value.trim();
    if (initCls) {
        let initName = 'Worldwide Coverage';
        iconCards.forEach(card => {
            if (card.getAttribute('data-icon-class') === initCls) {
                initName = card.getAttribute('data-icon-name');
            }
        });
        setSelectedIcon(initCls, initName);
    }
});
</script>
@endpush
