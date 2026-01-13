<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-white shadow">
        <div class="mx-auto max-w-6xl px-6 py-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-widest text-gray-500">Admin</p>
                <h1 class="text-2xl font-semibold">@yield('heading', 'Admin')</h1>
            </div>
            <nav class="flex flex-wrap gap-3 text-sm font-medium text-gray-600">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-900">Dashboard</a>
                <a href="{{ route('admin.categories.index') }}" class="hover:text-gray-900">Categories</a>
                <a href="{{ route('admin.services.index') }}" class="hover:text-gray-900">Services</a>
                <a href="{{ route('admin.projects.index') }}" class="hover:text-gray-900">Projects</a>
                <a href="{{ route('admin.quote-requests.index') }}" class="hover:text-gray-900">Quote Requests</a>
                <a href="{{ route('admin.bookings.index') }}" class="hover:text-gray-900">Bookings</a>
                <a href="{{ route('admin.blocked-times.index') }}" class="hover:text-gray-900">Blocked Times</a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-6 py-10">
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
