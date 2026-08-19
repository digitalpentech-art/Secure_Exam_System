<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Secure Examination System') }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-50 text-gray-900 font-sans flex flex-col min-h-screen">

        <!-- Navbar -->
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <a href="/" class="text-xl font-bold text-blue-600">SES Portal</a>
                <div class="flex gap-6">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-blue-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-gray-600 hover:text-blue-600">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
        </nav>

        <div class="flex-grow">
            <!-- Hero Section -->
            <header class="bg-blue-600 text-white py-20">
                <div class="max-w-5xl mx-auto px-6 text-center">
                    <h1 class="text-5xl font-extrabold mb-6">Secure Examination System</h1>
                    <p class="text-xl mb-8 text-blue-100">A reliable, efficient, and secure platform designed to handle all your assessment needs with confidence.</p>
                    @guest
                        <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Get Started</a>
                    @else
                        @if(auth()->user()->role === 'admin')
                            <a href="/admin/dashboard" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Dashboard</a>
                        @elseif(auth()->user()->role === 'lecturer')
                            <a href="/lecturer/dashboard" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Dashboard</a>
                        @else
                            <a href="/dashboard" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Dashboard</a>
                        @endif
                    @endguest

                </div>
            </header>

            <!-- Features Section -->
            <section class="max-w-7xl mx-auto px-6 py-16">
                <h2 class="text-3xl font-bold text-center mb-12">System Features</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
                        <h3 class="font-semibold text-xl mb-3">Manage Courses</h3>
                        <p class="text-gray-600">Create, organize, and maintain your institution's curriculum data seamlessly.</p>
                    </div>
                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
                        <h3 class="font-semibold text-xl mb-3">Create Exams</h3>
                        <p class="text-gray-600">Design complex assessments with powerful tools and robust question banks.</p>
                    </div>
                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
                        <h3 class="font-semibold text-xl mb-3">Secure Assessment</h3>
                        <p class="text-gray-600">Provide a secure, proctored environment for students to perform exams.</p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-gray-400 py-10">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <p>&copy; {{ date('Y') }} Secure Examination System. All rights reserved.</p>
            </div>
        </footer>

    </body>
</html>
