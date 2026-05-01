<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Attendance Tracker | Faculty Portal</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-slate-900 font-sans selection:bg-blue-200">
    
    <!-- Subtle Grid Background -->
    <div class="absolute inset-0 z-[-1] bg-[url('https://laravel.com/assets/img/welcome/background.svg')] bg-center bg-no-repeat opacity-20"></div>

    <div class="min-h-screen flex flex-col justify-between">
        
        <!-- Official Header -->
        <header class="w-full py-5 px-4 sm:px-6 lg:px-8 bg-white border-b border-slate-200/80 shadow-sm">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <!-- ACTUAL GCCS LOGO -->
                    <img src="{{ asset('GCCS.png') }}" alt="GCCS Logo" class="w-14 h-14 object-contain drop-shadow-sm">
                    
                    <div>
                        <h1 class="text-xl font-extrabold text-slate-800 leading-none tracking-tight">College of Computer Studies</h1>
                        <p class="text-xs text-slate-500 font-bold tracking-widest uppercase mt-1">Gordon College</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Hero Content -->
        <main class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
            <div class="max-w-6xl w-full grid md:grid-cols-2 gap-16 items-center">

                <!-- Left Column: Copy & Actions -->
                <div class="space-y-8 text-center md:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-sm font-bold tracking-wide shadow-sm">
                        <svg class="w-4 h-4 -ml-1 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Faculty Access Portal
                    </div>

                    <h2 class="text-5xl md:text-6xl font-black text-slate-900 tracking-tight leading-tight">
                        Student <span class="text-blue-700">Attendance</span> Tracker
                    </h2>

                    <p class="text-lg text-slate-600 max-w-lg mx-auto md:mx-0 leading-relaxed font-medium">
                        A centralized system designed to monitor class participation, generate cumulative reports, and streamline academic record-keeping for professors.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start pt-2">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex justify-center items-center px-8 py-3.5 border border-transparent text-base font-bold rounded-lg text-white bg-blue-700 hover:bg-blue-800 shadow-md hover:shadow-lg transition-all">
                                    Access Dashboard &rarr;
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-8 py-3.5 border border-transparent text-base font-bold rounded-lg text-white bg-blue-700 hover:bg-blue-800 shadow-md hover:shadow-lg transition-all focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                                    Teacher Login
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-8 py-3.5 border border-slate-300 text-base font-bold rounded-lg text-slate-700 bg-white hover:bg-slate-50 shadow-sm hover:shadow transition-all focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                                        Register Account
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>

                <!-- Right Column: Visual Feature Card -->
                <div class="hidden md:block">
                    <div class="relative rounded-2xl bg-white shadow-2xl ring-1 ring-slate-900/5 p-8">
                        <!-- Decorative glow -->
                        <div class="absolute -top-6 -right-6 w-32 h-32 bg-blue-100 rounded-full blur-3xl opacity-60"></div>
                        <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-green-100 rounded-full blur-3xl opacity-60"></div>

                        <div class="relative space-y-8">
                            <div class="border-b border-slate-100 pb-5">
                                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest">System Capabilities</h3>
                            </div>
                            
                            <div class="space-y-6">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-extrabold text-slate-800 text-lg">Multi-Class Management</p>
                                        <p class="text-sm text-slate-500 font-medium">Organize rosters and schedules</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center text-green-600 border border-green-100">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-extrabold text-slate-800 text-lg">Real-time Logging</p>
                                        <p class="text-sm text-slate-500 font-medium">Mark present, late, or absent instantly</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 rounded-xl bg-yellow-50 flex items-center justify-center text-yellow-600 border border-yellow-100">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-extrabold text-slate-800 text-lg">Cumulative Gradebooks</p>
                                        <p class="text-sm text-slate-500 font-medium">Generate end-of-semester reports</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <!-- Official Footer -->
        <footer class="w-full py-6 text-center border-t border-slate-200 bg-white mt-auto">
            <p class="text-sm text-slate-500 font-medium">
                &copy; 2026 Developed by <span class="text-slate-800 font-extrabold">Troyler</span>. All rights reserved.
            </p>
        </footer>
        
    </div>
</body>
</html>