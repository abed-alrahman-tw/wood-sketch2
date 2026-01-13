@php
    $isEdit = isset($service);
@endphp

<div class="grid gap-6 md:grid-cols-2">
    <div>
        <label class="block text-sm font-medium text-gray-700" for="name">Name</label>
        <input
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $service->name ?? '') }}"
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
            value="{{ old('slug', $service->slug ?? '') }}"
            required
        />
        @error('slug')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700" for="description">Description</label>
    <textarea
        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        id="description"
        name="description"
        rows="4"
    >{{ old('description', $service->description ?? '') }}</textarea>
    @error('description')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-6 grid gap-6 md:grid-cols-2">
    <div>
        <label class="block text-sm font-medium text-gray-700" for="starting_price">Starting Price</label>
        <input
            class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            id="starting_price"
            name="starting_price"
            type="number"
            step="0.01"
            min="0"
            value="{{ old('starting_price', $service->starting_price ?? '') }}"
        />
        @error('starting_price')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-3">
        <input
            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
            id="is_active"
            name="is_active"
            type="checkbox"
            value="1"
            {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}
        />
        <label class="text-sm font-medium text-gray-700" for="is_active">Active</label>
    </div>
</div>

<div class="mt-6 flex items-center justify-between">
    <a class="text-sm font-medium text-gray-600 hover:text-gray-900" href="{{ route('admin.services.index') }}">
        Back to services
    </a>
    <button class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500" type="submit">
        {{ $isEdit ? 'Update Service' : 'Create Service' }}
    </button>
</div>
