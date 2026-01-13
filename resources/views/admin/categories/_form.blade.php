@php
    $isEdit = isset($category);
@endphp

<div class="grid gap-6 md:grid-cols-2">
    <div>
        <label class="block text-sm font-medium text-gray-700" for="name">Name</label>
        <input
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $category->name ?? '') }}"
            required
        />
        @error('name')
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
            value="{{ old('slug', $category->slug ?? '') }}"
            required
        />
        @error('slug')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-6 flex items-center justify-between">
    <a class="text-sm font-medium text-gray-600 hover:text-gray-900" href="{{ route('admin.categories.index') }}">
        Back to categories
    </a>
    <button class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500" type="submit">
        {{ $isEdit ? 'Update Category' : 'Create Category' }}
    </button>
</div>
