<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SES') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-xl font-bold text-blue-600">SES Portal</a>
            <div class="flex gap-4 items-center">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="/admin/dashboard" class="text-gray-600 hover:text-blue-600 font-medium">Dashboard</a>
                    @elseif(auth()->user()->role === 'lecturer')
                        <a href="/lecturer/dashboard" class="text-gray-600 hover:text-blue-600 font-medium">Dashboard</a>
                    @else
                        <a href="/dashboard" class="text-gray-600 hover:text-blue-600 font-medium">Dashboard</a>
                    @endif
                    <span class="text-gray-700">Hi, {{ auth()->user()->name }}</span>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-red-600 text-sm">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @include('components.flash-messages')

    <!-- Content -->
    <main class="flex-grow max-w-7xl mx-auto px-6 py-8 w-full">
        @yield('content')
    </main>

    <script>
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const btn = this.querySelector('button[type="submit"]');
                if (btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                    btn.textContent = 'Processing...';
                }
            });
        });
    </script>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-400 py-6 text-center">
        <p>&copy; {{ date('Y') }} Secure Examination System.</p>
    </footer>
</body>
</html>
