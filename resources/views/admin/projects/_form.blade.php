@php
    $isEdit = isset($project);
@endphp

<div class="grid gap-6 md:grid-cols-2">
    <div>
        <label class="block text-sm font-medium text-gray-700" for="title">Title</label>
        <input
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            id="title"
            name="title"
            type="text"
            value="{{ old('title', $project->title ?? '') }}"
            required
        />
        @error('title')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700" for="slug">Slug</label>
        <input
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            id="slug"
            name="slug"
            type="text"
            value="{{ old('slug', $project->slug ?? '') }}"
            required
        />
        @error('slug')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700" for="category_id">Category</label>
        <select
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            id="category_id"
            name="category_id"
            required
        >
            <option value="">Select a category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $project->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700" for="status">Status</label>
        <select
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            id="status"
            name="status"
            required
        >
            <option value="draft" {{ old('status', $project->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ old('status', $project->status ?? '') === 'published' ? 'selected' : '' }}>Published</option>
        </select>
        @error('status')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700" for="short_description">Short Description</label>
    <input
        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        id="short_description"
        name="short_description"
        type="text"
        value="{{ old('short_description', $project->short_description ?? '') }}"
        required
    />
    @error('short_description')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700" for="description">Description</label>
    <textarea
        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        id="description"
        name="description"
        rows="6"
        required
    >{{ old('description', $project->description ?? '') }}</textarea>
    @error('description')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-6 grid gap-6 md:grid-cols-2">
    <div>
        <label class="block text-sm font-medium text-gray-700" for="location_text">Location</label>
        <input
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            id="location_text"
            name="location_text"
            type="text"
            value="{{ old('location_text', $project->location_text ?? '') }}"
        />
        @error('location_text')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700" for="completion_date">Completion Date</label>
        <input
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            id="completion_date"
            name="completion_date"
            type="date"
            value="{{ old('completion_date', isset($project->completion_date) ? $project->completion_date->format('Y-m-d') : '') }}"
        />
        @error('completion_date')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700" for="video_url">Video URL</label>
        <input
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            id="video_url"
            name="video_url"
            type="url"
            value="{{ old('video_url', $project->video_url ?? '') }}"
        />
        @error('video_url')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700" for="tags">Tags (comma-separated)</label>
        <input
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            id="tags"
            name="tags"
            type="text"
            value="{{ old('tags', isset($project->tags) ? implode(', ', $project->tags) : '') }}"
        />
        @error('tags')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700" for="cover_image">Cover Image</label>
    <input
        class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100"
        id="cover_image"
        name="cover_image"
        type="file"
        accept="image/*"
        {{ $isEdit ? '' : 'required' }}
    />
    @error('cover_image')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
    @if ($isEdit && $project->cover_image)
        <div class="mt-3">
            <p class="text-xs uppercase tracking-wide text-gray-500">Current cover</p>
            <img class="mt-2 h-28 w-44 rounded-lg object-cover" src="{{ asset('storage/'.$project->cover_image) }}" alt="{{ $project->title }}">
        </div>
    @endif
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700" for="gallery_images">Gallery Images</label>
    <input
        class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100"
        id="gallery_images"
        name="gallery_images[]"
        type="file"
        accept="image/*"
        multiple
        {{ $isEdit ? '' : 'required' }}
    />
    @error('gallery_images')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
    @error('gallery_images.*')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
    @if ($isEdit && $project->gallery_images)
        <div class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-4">
            @foreach ($project->gallery_images as $galleryImage)
                <img class="h-24 w-full rounded-lg object-cover" src="{{ asset('storage/'.$galleryImage) }}" alt="Gallery image">
            @endforeach
        </div>
    @endif
</div>

<div class="mt-6 grid gap-6 md:grid-cols-2">
    <div>
        <label class="block text-sm font-medium text-gray-700" for="before_image">Before Image</label>
        <input
            class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100"
            id="before_image"
            name="before_image"
            type="file"
            accept="image/*"
        />
        @error('before_image')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
        @if ($isEdit && $project->before_image)
            <img class="mt-3 h-24 w-36 rounded-lg object-cover" src="{{ asset('storage/'.$project->before_image) }}" alt="Before image">
        @endif
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700" for="after_image">After Image</label>
        <input
            class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100"
            id="after_image"
            name="after_image"
            type="file"
            accept="image/*"
        />
        @error('after_image')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
        @if ($isEdit && $project->after_image)
            <img class="mt-3 h-24 w-36 rounded-lg object-cover" src="{{ asset('storage/'.$project->after_image) }}" alt="After image">
        @endif
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <input
        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
        id="is_featured"
        name="is_featured"
        type="checkbox"
        value="1"
        {{ old('is_featured', $project->is_featured ?? false) ? 'checked' : '' }}
    />
    <label class="text-sm font-medium text-gray-700" for="is_featured">Featured project</label>
</div>

<div class="mt-8 flex items-center justify-between">
    <a class="text-sm font-medium text-gray-600 hover:text-gray-900" href="{{ route('admin.projects.index') }}">
        Back to projects
    </a>
    <button class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500" type="submit">
        {{ $isEdit ? 'Update Project' : 'Create Project' }}
    </button>
</div>
