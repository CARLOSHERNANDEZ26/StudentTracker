<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Review & Edit Attendance') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <!-- Header Info -->
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $course->course_code }}</h3>
                            <p class="text-md text-gray-600">{{ $course->course_name }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-3 py-1 text-sm font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                Date: {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- The Edit Form -->
                    <form method="POST" action="{{ route('attendances.review.update', $course->id) }}">
                        @csrf
                        <input type="hidden" name="date" value="{{ $date }}">

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 mb-6 border-b border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Student Name</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-green-600 uppercase">Present</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-yellow-600 uppercase">Late</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-red-600 uppercase">Absent</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($attendances as $record)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $record->student->full_formatted_name }}
                                                
                                                <!-- Visual indicator of their current saved status -->
                                                @if($record->status == 'Present')
                                                    <span class="ml-2 inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">Saved: Present</span>
                                                @elseif($record->status == 'Late')
                                                    <span class="ml-2 inline-flex items-center rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-800">Saved: Late</span>
                                                @else
                                                    <span class="ml-2 inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">Saved: Absent</span>
                                                @endif
                                            </td>
                                            
                                            <!-- Pre-checking the radio buttons based on database values -->
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <input type="radio" name="attendances[{{ $record->id }}]" value="Present" {{ $record->status == 'Present' ? 'checked' : '' }} class="h-5 w-5 text-green-600 focus:ring-green-500 cursor-pointer">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <input type="radio" name="attendances[{{ $record->id }}]" value="Late" {{ $record->status == 'Late' ? 'checked' : '' }} class="h-5 w-5 text-yellow-500 focus:ring-yellow-500 cursor-pointer">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <input type="radio" name="attendances[{{ $record->id }}]" value="Absent" {{ $record->status == 'Absent' ? 'checked' : '' }} class="h-5 w-5 text-red-600 focus:ring-red-500 cursor-pointer">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="flex justify-end items-center gap-4">
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Cancel</a>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-md font-bold hover:bg-blue-700 shadow-sm transition">
                                Update Attendance
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>