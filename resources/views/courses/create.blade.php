<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Class') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8">
                    <form action="{{ route('courses.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Course Code</label>
                            <input type="text" name="course_code" placeholder="e.g. IT-301" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Course Name</label>
                            <input type="text" name="course_name" placeholder="e.g. Advanced Web Development" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>

                        <!-- Replaced Schedule Section -->
                        <div class="space-y-6 pt-2 border-t border-gray-100">
                            
                            <!-- Day Picker Pills -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Schedule Days</label>
                                <div class="flex flex-wrap gap-2">
                                    @php $days = ['M' => 'Mon', 'T' => 'Tue', 'W' => 'Wed', 'Th' => 'Thu', 'F' => 'Fri', 'S' => 'Sat']; @endphp
                                    
                                    @foreach($days as $value => $label)
                                        <label class="cursor-pointer">
                                            <!-- Hidden checkbox, but functional -->
                                            <input type="checkbox" name="days[]" value="{{ $value }}" class="peer sr-only">
                                            <!-- The visual "Pill" -->
                                            <div class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-600 transition-all hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:bg-blue-600 peer-checked:text-white peer-focus:ring-2 peer-focus:ring-blue-600 peer-focus:ring-offset-2">
                                                {{ $label }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('days') <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <!-- Native Time Pickers -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Start Time</label>
                                    <input type="time" name="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-700" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">End Time</label>
                                    <input type="time" name="end_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-700" required>
                                </div>
                            </div>

                        </div>

                        <div class="flex items-center justify-end pt-6 border-t border-gray-100 mt-6">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4 font-medium">Cancel</a>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-blue-700 transition shadow-sm">
                                Create Class
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>