@csrf

<div class="admin-form-grid">

    {{-- Title --}}
    <div class="admin-form-group full-width">
        <label for="title">
            Blog Title
            <span class="required">*</span>
        </label>

        <input
            type="text"
            name="title"
            id="title"
            class="admin-form-control
                @error('title') is-invalid @enderror"
            value="{{ old('title', $blog->title ?? '') }}"
            placeholder="Enter blog title"
            required
        >

        @error('title')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Category --}}
    <div class="admin-form-group">
        <label for="category_id">
            Category
            <span class="required">*</span>
        </label>

        <select
            name="category_id"
            id="category_id"
            class="admin-form-control
                @error('category_id') is-invalid @enderror"
            required
        >
            <option value="">
                Select Category
            </option>

            @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected(
                        old(
                            'category_id',
                            $blog->category_id ?? ''
                        ) == $category->id
                    )
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        @error('category_id')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Author --}}
    <div class="admin-form-group">
        <label for="author_id">
            Author
        </label>

        <select
            name="author_id"
            id="author_id"
            class="admin-form-control
                @error('author_id') is-invalid @enderror"
        >
            <option value="">
                Open Sky Team
            </option>

            @foreach ($authors as $author)
                <option
                    value="{{ $author->id }}"
                    @selected(
                        old(
                            'author_id',
                            $blog->author_id ?? ''
                        ) == $author->id
                    )
                >
                    {{ $author->name }}
                </option>
            @endforeach
        </select>

        @error('author_id')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Slug --}}
    <div class="admin-form-group full-width">
        <label for="slug">
            Slug
        </label>

        <input
            type="text"
            name="slug"
            id="slug"
            class="admin-form-control
                @error('slug') is-invalid @enderror"
            value="{{ old('slug', $blog->slug ?? '') }}"
            placeholder="Leave empty to generate automatically"
        >

        @error('slug')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Short Description --}}
    <div class="admin-form-group full-width">
        <label for="short_description">
            Short Description
            <span class="required">*</span>
        </label>

        <textarea
            name="short_description"
            id="short_description"
            rows="4"
            class="admin-form-control
                @error('short_description') is-invalid @enderror"
            placeholder="Enter short blog description"
            required
        >{{ old(
            'short_description',
            $blog->short_description ?? ''
        ) }}</textarea>

        @error('short_description')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Complete Content --}}
    <div class="admin-form-group full-width">
        <label for="content">
            Complete Blog Content
            <span class="required">*</span>
        </label>

        <textarea
            name="content"
            id="content"
            rows="15"
            class="admin-form-control
                @error('content') is-invalid @enderror"
            placeholder="Enter complete blog content"
            required
        >{{ old('content', $blog->content ?? '') }}</textarea>

        @error('content')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Featured Image --}}
    <div class="admin-form-group">
        <label for="featured_image">
            Featured Image
            @if (!isset($blog))
                <span class="required">*</span>
            @endif
        </label>

        <input
            type="file"
            name="featured_image"
            id="featured_image"
            class="admin-form-control
                @error('featured_image') is-invalid @enderror"
            accept=".jpg,.jpeg,.png,.webp"
            @required(!isset($blog))
        >

        @error('featured_image')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror

        @isset($blog)
            @if ($blog->featured_image)
                <div class="admin-image-preview">
                    <img
                        src="{{ asset(
                            'storage/' . $blog->featured_image
                        ) }}"
                        alt="{{ $blog->title }}"
                        width="180"
                    >
                </div>
            @endif
        @endisset
    </div>

    {{-- Read Time --}}
    <div class="admin-form-group">
        <label for="read_time">
            Read Time in Minutes
            <span class="required">*</span>
        </label>

        <input
            type="number"
            name="read_time"
            id="read_time"
            min="1"
            max="120"
            class="admin-form-control
                @error('read_time') is-invalid @enderror"
            value="{{ old(
                'read_time',
                $blog->read_time ?? 5
            ) }}"
            required
        >

        @error('read_time')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Published Date --}}
    <div class="admin-form-group">
        <label for="published_at">
            Published Date
        </label>

        <input
            type="datetime-local"
            name="published_at"
            id="published_at"
            class="admin-form-control
                @error('published_at') is-invalid @enderror"
            value="{{ old(
                'published_at',
                isset($blog) && $blog->published_at
                    ? $blog->published_at->format('Y-m-d\TH:i')
                    : ''
            ) }}"
        >

        @error('published_at')
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
            name="status"
            id="status"
            class="admin-form-control
                @error('status') is-invalid @enderror"
            required
        >
            <option
                value="1"
                @selected(
                    old('status', $blog->status ?? 0) == 1
                )
            >
                Published
            </option>

            <option
                value="0"
                @selected(
                    old('status', $blog->status ?? 0) == 0
                )
            >
                Draft
            </option>
        </select>

        @error('status')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Meta Title --}}
    <div class="admin-form-group full-width">
        <label for="meta_title">
            Meta Title
        </label>

        <input
            type="text"
            name="meta_title"
            id="meta_title"
            class="admin-form-control
                @error('meta_title') is-invalid @enderror"
            value="{{ old(
                'meta_title',
                $blog->meta_title ?? ''
            ) }}"
            placeholder="SEO title"
        >

        @error('meta_title')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Meta Description --}}
    <div class="admin-form-group full-width">
        <label for="meta_description">
            Meta Description
        </label>

        <textarea
            name="meta_description"
            id="meta_description"
            rows="4"
            class="admin-form-control
                @error('meta_description') is-invalid @enderror"
            placeholder="SEO description"
        >{{ old(
            'meta_description',
            $blog->meta_description ?? ''
        ) }}</textarea>

        @error('meta_description')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

</div>

<div class="admin-form-actions">
    <a
        href="{{ route('admin.blogs.index') }}"
        class="btn btn-light"
    >
        Cancel
    </a>

    <button
        type="submit"
        class="btn btn-primary"
    >
        {{ $buttonText ?? 'Save Blog' }}
    </button>
</div>