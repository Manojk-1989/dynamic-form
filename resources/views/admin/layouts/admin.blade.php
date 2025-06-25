<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Dashboard' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/sweet-alert.js') }}"></script>


</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Sidebar -->
    <div class="flex h-screen">
        <aside class="w-64 bg-gray-900 text-gray-100 flex flex-col">
            <div class="p-4 text-xl font-bold border-b border-gray-700">
                Admin Panel
            </div>

            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-2 py-1 rounded hover:bg-gray-700">Form List</a>
                <a href="{{ route('admin.forms.index') }}" class="block px-2 py-1 rounded hover:bg-gray-700">Create Form</a>
            </nav>

            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-2 py-1 rounded bg-red-600 hover:bg-red-700">Logout</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow p-4 flex items-center justify-between">
                <h1 class="text-2xl font-semibold">{{ $header ?? 'Dashboard' }}</h1>
            </header>

            <!-- Content -->
            <section class="p-6 overflow-auto">
                @yield('content')
            </section>
        </main>
    </div>
@yield('scripts')
</body>
</html>
