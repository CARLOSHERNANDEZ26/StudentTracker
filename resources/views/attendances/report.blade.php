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
                        
                        <!-- A neat visual trick: using browser print functionality for instant "Export" -->
                        <button onclick="window.print()" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5 2.75C5 1.784 5.784 1 6.75 1h6.5c.966 0 1.75.784 1.75 1.75v3.552c.377.046.752.097 1.126.153A2.212 2.212 0 0118 8.653v4.083A2.25 2.25 0 0115.75 15h-.241l.305 1.984A1.75 1.75 0 0114.084 19H5.915a1.75 1.75 0 01-1.73-2.016L4.492 15H4.25A2.25 2.25 0 012 12.736V8.653c0-1.082.775-2.034 1.874-2.198.374-.056.75-.107 1.127-.153L5 6.25v-3.5zm8.5 3.397a41.533 41.533 0 00-7 0V2.5h7v3.647zM5.5 15v2.25c0 .138.112.25.25.25h8.5a.25.25 0 00.25-.25V15h-9zM4 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                            Print Report
                        </button>
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
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-lg">
                    <p class="text-blue-700 font-medium">Please select a class from the dropdown above to view its cumulative attendance report.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>