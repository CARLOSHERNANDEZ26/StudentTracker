<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance Summary Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Class Selector -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="GET" action="{{ route('attendances.report') }}" class="flex flex-col sm:flex-row items-center gap-4">
                        <label for="course_id" class="font-bold text-gray-700">Select Class for Report:</label>
                        <select name="course_id" id="course_id" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 w-full sm:w-1/2">
                            <option value="">-- Choose a Class --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ $selectedCourseId == $course->id ? 'selected' : '' }}>
                                    {{ $course->course_code }} - {{ $course->course_name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <!-- The Gradebook Summary Matrix -->
            @if($selectedCourseId)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Cumulative Report: {{ $selectedCourse->course_code }}</h3>
                            <p class="text-sm text-gray-500">Semester Summary</p>
                        </div>
                        

                    </div>

                    <div class="p-0 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Student Name</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider border-l border-gray-600">Total Classes</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-green-300 uppercase tracking-wider border-l border-gray-600">Presents</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-yellow-300 uppercase tracking-wider border-l border-gray-600">Lates</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-red-300 uppercase tracking-wider border-l border-gray-600">Absents</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($reportData as $row)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $row['student']->full_formatted_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 font-bold border-l border-gray-100">
                                            {{ $row['total_classes'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-green-600 border-l border-gray-100 bg-green-50/10">
                                            {{ $row['present_count'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-yellow-600 border-l border-gray-100 bg-yellow-50/10">
                                            {{ $row['late_count'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-red-600 border-l border-gray-100 bg-red-50/10">
                                            {{ $row['absent_count'] }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                                            No students found in this class.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        <</table>
                    </div>
                    
                    @if(isset($paginatedStudents) && $paginatedStudents->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                            {{ $paginatedStudents->links() }}
                        </div>
                    @endif

                </div>
            @else
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-lg">
                    <p class="text-blue-700 font-medium">Please select a class from the dropdown above to view its cumulative attendance report.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>