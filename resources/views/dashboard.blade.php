<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Total Registered Students:") }} {{ $studentCount }}
                </div>
          <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
        <h3 class="text-green-800 font-bold mb-3 flex items-center">
            <span class="mr-2">✅</span> Present Today ({{ $presentToday->count() }})
        </h3>
        @forelse($presentToday as $attendance)
            <p class="text-green-700 text-sm mb-1">• {{ $attendance->student->full_formatted_name }}</p>
        @empty
            <p class="text-green-600 italic text-sm">No one present yet.</p>
        @endforelse
    </div>

    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
        <h3 class="text-yellow-800 font-bold mb-3 flex items-center">
            <span class="mr-2">⏰</span> Late Today ({{ $lateToday->count() }})
        </h3>
        @forelse($lateToday as $attendance)
           <p class="text-yellow-700 text-sm mb-1">• {{ $attendance->student->full_formatted_name }}</p>
        @empty
            <p class="text-yellow-600 italic text-sm">No lates recorded.</p>
        @endforelse
    </div>
</div>   </div>
        </div>
    </div>
</x-app-layout>
