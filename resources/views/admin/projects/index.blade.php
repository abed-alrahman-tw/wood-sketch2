@extends('admin.layout')

@section('title', 'Projects')
@section('heading', 'Projects')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-gray-600">Manage portfolio projects and galleries.</p>
        <a class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500" href="{{ route('admin.projects.create') }}">
            New Project
        </a>
    </div>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Project</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Featured</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($projects as $project)
                    @php
                        $thumbPath = $project->coverThumbnailPath();
                        $thumbUrl = $thumbPath ? asset('storage/'.$thumbPath) : null;
                    @endphp
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                @if ($thumbUrl)
                                    <img class="h-14 w-20 rounded-lg object-cover" src="{{ $thumbUrl }}" alt="{{ $project->title }}">
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $project->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $project->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $project->category?->name }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $project->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $project->is_featured ? 'Yes' : 'No' }}
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <div class="inline-flex items-center gap-2">
                                <a class="text-indigo-600 hover:text-indigo-900" href="{{ route('admin.projects.edit', $project) }}">Edit</a>
                                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Delete this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-8 text-center text-sm text-gray-500" colspan="5">No projects yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $projects->links() }}
    </div>
@endsection
