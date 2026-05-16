<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden bg-slate-50">
        
        <!-- Subtle Background Pattern (Matches the Landing Page) -->
        <div class="absolute inset-0 z-0 bg-[url('https://laravel.com/assets/img/welcome/background.svg')] bg-center bg-no-repeat opacity-10"></div>

        <div class="relative z-10 w-full sm:max-w-md mt-6 px-10 py-12 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border border-slate-200/60">
            
            <!-- Branding Header -->
            <div class="text-center mb-10">
                <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
                    <img src="{{ asset('GCCS.png') }}" alt="GCCS Logo" class="h-14 w-14 object-contain">
                </div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Faculty Login</h2>
                <p class="text-sm font-medium text-slate-500 mt-2 italic">Access your attendance dashboards</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
    <label for="email" class="block text-sm font-bold leading-6 text-slate-700 uppercase tracking-wider">Official Email Address</label>
    <div class="mt-2">
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="name@gordoncollege.edu.ph"
            class="block w-full rounded-lg border-slate-300 py-3 text-slate-900 shadow-sm focus:border-blue-600 focus:ring-blue-600 sm:text-sm">
    </div>
    <p class="text-xs text-slate-500 mt-1 italic">Must be an @gordoncollege.edu.ph domain.</p>
    
    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 font-medium" />
</div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-bold leading-6 text-slate-700 uppercase tracking-wider">Password</label>
                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-bold text-blue-700 hover:text-blue-800 transition">Forgot?</a>
                            </div>
                        @endif
                    </div>
                    <div class="mt-2">
                        <input id="password" type="password" name="password" required autocomplete="current-password" 
                            class="block w-full rounded-lg border-slate-300 py-3 text-slate-900 shadow-sm focus:border-blue-600 focus:ring-blue-600 sm:text-sm">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 font-medium" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-700 focus:ring-blue-600" name="remember">
                    <label for="remember_me" class="ml-3 block text-sm font-medium text-slate-600">Keep me signed in</label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="flex w-full justify-center rounded-lg bg-blue-700 px-3 py-3.5 text-sm font-bold text-white shadow-md hover:bg-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 transition-all active:scale-95">
                        Sign In to Portal
                    </button>
                </div>

                <!-- Registration Link (Handy for new Faculty) -->
                @if (Route::has('register'))
                    <p class="text-center text-sm text-slate-500 mt-4">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="font-bold text-blue-700 hover:underline">Register here</a>
                    </p>
                @endif
            </form>
        </div>
    </div>
</x-guest-layout>php ariphp