<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $course->course_code }}: {{ $course->course_name }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Class Schedule Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between bg-blue-50">
                    <div>
                        <h3 class="text-lg font-bold text-blue-900">Class Schedule</h3>
                        <p class="text-blue-700">{{ $course->schedule_days }} | {{ $course->schedule_time }}</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <form action="{{ route('courses.enroll', $course->id) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            <select name="student_id" class="rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select Student to Enroll</option>
                                @foreach($availableStudents as $student)
                                    <option value="{{ $student->id }}">{{ $student->full_formatted_name }}</p>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-bold hover:bg-blue-700">
                                Enroll
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Student Roster Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Class Roster ({{ $course->students->count() }} Students)</h3>
                    
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($course->students as $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $student->student_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $student->full_formatted_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button class="text-red-600 hover:text-red-900 font-semibold">Unenroll</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-gray-500 italic">
                                        No students enrolled in this class yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>