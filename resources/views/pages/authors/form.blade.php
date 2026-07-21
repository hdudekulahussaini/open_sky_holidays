@csrf

<div class="admin-form-grid">

    {{-- Author Name --}}
    <div class="admin-form-group">
        <label for="name">
            Author Name
            <span class="required">*</span>
        </label>

        <input
            type="text"
            name="name"
            id="name"
            class="admin-form-control
                @error('name') is-invalid @enderror"
            value="{{ old('name', $author->name ?? '') }}"
            placeholder="Example: Sneha Patel"
            required
        >

        @error('name')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Author Image --}}
    <div class="admin-form-group">
        <label for="image">
            Author Image
        </label>

        <input
            type="file"
            name="image"
            id="image"
            class="admin-form-control
                @error('image') is-invalid @enderror"
            accept=".jpg,.jpeg,.png,.webp"
        >

        @error('image')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror

        @isset($author)
            @if ($author->image)
                <div class="admin-image-preview">
                    <img
                        src="{{ asset('storage/' . $author->image) }}"
                        alt="{{ $author->name }}"
                        width="100"
                    >
                </div>
            @endif
        @endisset
    </div>

    {{-- Description --}}
    <div class="admin-form-group full-width">
        <label for="description">
            Description
        </label>

        <textarea
            name="description"
            id="description"
            rows="5"
            class="admin-form-control
                @error('description') is-invalid @enderror"
            placeholder="Enter author description"
        >{{ old('description', $author->description ?? '') }}</textarea>

        @error('description')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Twitter --}}
    <div class="admin-form-group">
        <label for="twitter_url">
            Twitter URL
        </label>

        <input
            type="url"
            name="twitter_url"
            id="twitter_url"
            class="admin-form-control
                @error('twitter_url') is-invalid @enderror"
            value="{{ old(
                'twitter_url',
                $author->twitter_url ?? ''
            ) }}"
            placeholder="https://twitter.com/username"
        >

        @error('twitter_url')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Facebook --}}
    <div class="admin-form-group">
        <label for="facebook_url">
            Facebook URL
        </label>

        <input
            type="url"
            name="facebook_url"
            id="facebook_url"
            class="admin-form-control
                @error('facebook_url') is-invalid @enderror"
            value="{{ old(
                'facebook_url',
                $author->facebook_url ?? ''
            ) }}"
            placeholder="https://facebook.com/username"
        >

        @error('facebook_url')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- LinkedIn --}}
    <div class="admin-form-group">
        <label for="linkedin_url">
            LinkedIn URL
        </label>

        <input
            type="url"
            name="linkedin_url"
            id="linkedin_url"
            class="admin-form-control
                @error('linkedin_url') is-invalid @enderror"
            value="{{ old(
                'linkedin_url',
                $author->linkedin_url ?? ''
            ) }}"
            placeholder="https://linkedin.com/in/username"
        >

        @error('linkedin_url')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Status --}}
    <div class="admin-form-group">
        <label for="status">
            Status
            <span class="required">*</span>
        </label>

        <select
            id="status"
            name="status"
            class="admin-form-control
                @error('status') is-invalid @enderror"
            required
        >
            <option
                value="1"
                @selected(
                    old('status', $author->status ?? 1) == 1
                )
            >
                Active
            </option>

            <option
                value="0"
                @selected(
                    old('status', $author->status ?? 1) == 0
                )
            >
                Inactive
            </option>
        </select>

        @error('status')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

</div>

<div class="admin-form-actions">
    <a
        href="{{ route('admin.authors.index') }}"
        class="btn btn-light"
    >
        Cancel
    </a>

    <button
        type="submit"
        class="btn btn-primary"
    >
        {{ $buttonText ?? 'Save Author' }}
    </button>
</div>