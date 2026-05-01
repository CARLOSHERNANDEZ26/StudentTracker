<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Record Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- STEP 1: Class Selector -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="GET" action="{{ route('attendances.create') }}" class="flex flex-col sm:flex-row items-center gap-4">
                        <label for="course_id" class="font-bold text-gray-700">Select Class:</label>
                        <!-- onchange="this.form.submit()" makes the page instantly reload with the new class data -->
                        <select name="course_id" id="course_id" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 w-full sm:w-1/2">
                            <option value="">-- Choose a Class to start --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ $selectedCourseId == $course->id ? 'selected' : '' }}>
                                    {{ $course->course_code }} - {{ $course->course_name }} ({{ $course->schedule_days }})
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <!-- STEP 2: The Roster & Attendance Form (Only shows if a class is selected) -->
            @if($selectedCourseId)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Attendance Sheet: {{ $selectedCourse->course_code }}</h3>
                                <p class="text-sm text-gray-500">Marking attendance for {{ $students->count() }} enrolled students.</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('attendances.store') }}">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $selectedCourseId }}">
                            
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date of Class</label>
                                <input type="date" name="attendance_date" value="{{ date('Y-m-d') }}" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>

                            @if($students->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 mb-6 border-b border-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student Name</th>
                                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Present</th>
                                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Late</th>
                                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Absent</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($students as $student)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $student->full_formatted_name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        <input type="radio" name="attendances[{{ $student->id }}]" value="Present" class="h-5 w-5 text-green-600 focus:ring-green-500" required>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        <input type="radio" name="attendances[{{ $student->id }}]" value="Late" class="h-5 w-5 text-yellow-500 focus:ring-yellow-500" required>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        <input type="radio" name="attendances[{{ $student->id }}]" value="Absent" class="h-5 w-5 text-red-600 focus:ring-red-500" required>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md font-bold hover:bg-blue-700 shadow-sm transition">
                                        Save Attendance
                                    </button>
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-500 italic border-t border-gray-100 mt-4">
                                    No students are enrolled in this class yet. Go to the dashboard to enroll students first.
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            @else
                <!-- Friendly empty state when no class is selected yet -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-lg">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-blue-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-blue-700 font-medium">Please select a class from the dropdown above to load the roster and record attendance.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>