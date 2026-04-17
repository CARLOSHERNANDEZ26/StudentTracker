<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Attendance Tracker</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900 selection:bg-blue-500 selection:text-white">
    <div class="min-h-screen flex flex-col items-center justify-center relative overflow-hidden">
        
        <div class="absolute inset-0 z-0 bg-gradient-to-br from-blue-50 via-white to-gray-100"></div>

        <div class="relative z-10 w-full max-w-3xl px-6 text-center">
            
            <div class="mx-auto mb-8 flex h-16 w-16 items-center justify-center rounded-full bg-blue-100">
                <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>

            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-6xl mb-4">
                Student Attendance Tracker
            </h1>
            <p class="text-lg leading-8 text-gray-600 mb-10">
                A modern, efficient system designed to streamline classroom management, support faculty workflows, and keep educators focused on what matters most.
            </p>

            <div class="flex items-center justify-center gap-x-6">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-md bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all">
                            Return to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-md bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all">
                            Teacher Login
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-blue-600 transition-all">
                                Register an Account <span aria-hidden="true">→</span>
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>

        <div class="absolute bottom-6 w-full text-center text-sm text-gray-500 z-10 font-medium tracking-wide">
            Developed by The Walking Dev &copy; {{ date('Y') }}
        </div>
        
    </div>
</body>
</html>