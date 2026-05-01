<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard: My Classes') }}
            </h2>
            
            <a href="{{ route('courses.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 transition-all">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add New Class
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- 1. The Class Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @forelse($courses as $course)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 hover:border-blue-500 hover:shadow-md transition-all duration-200">
                        <div class="p-6">
                            <!-- Course Code & Name -->
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 mb-2">
                                        {{ $course->course_code }}
                                    </span>
                                    <h3 class="text-xl font-bold text-gray-900 leading-tight">{{ $course->course_name }}</h3>
                                </div>
                            </div>

                            <!-- Schedule Details -->
                            <div class="flex items-center text-sm text-gray-600 bg-gray-50 p-3 rounded-md border border-gray-100">
                                <svg class="mr-2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <span><strong>{{ $course->schedule_days }}</strong> &bull; {{ $course->schedule_time }}</span>
                            </div>

                            <!-- Enrollment & Action -->
                            <div class="mt-5 pt-4 border-t border-gray-100 flex justify-between items-center">
                                <div class="text-sm text-gray-600">
                                    <span class="font-semibold text-gray-900">{{ $course->students_count }}</span> Enrolled
                                </div>
                                
                                <a href="{{ route('courses.show', $course->id) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 flex items-center">
                                    Manage Class <span aria-hidden="true" class="ml-1">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State if no classes exist -->
                    <div class="col-span-full bg-white rounded-lg border-2 border-dashed border-gray-300 p-12 text-center shadow-sm">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">No classes found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new class schedule.</p>
                    </div>
                @endforelse
            </div>

            <!-- 2. Today's Attendance Overview (Scalable Summary Mode) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Today's Attendance Overview</h3>
                    <p class="text-sm text-gray-500 mb-6">Total Registered Students Across All Classes: {{ $studentCount }}</p>
                    
                    <div class="space-y-6">
                        @forelse($attendancesByCourse as $courseId => $attendances)
                            @php
                                // Grab the course details and calculate totals
                                $course = $attendances->first()->course;
                                $presents = $attendances->where('status', 'Present');
                                $lates = $attendances->where('status', 'Late');
                                $absents = $attendances->where('status', 'Absent');
                            @endphp

                            <!-- Individual Class Summary Card -->
                            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition bg-white">
                                <!-- Class Header -->
                                <div class="bg-gray-50 px-5 py-4 border-b border-gray-200 flex justify-between items-center">
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-lg">
                                            {{ $course->course_code }} - {{ $course->course_name }}
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $course->schedule_days }} | {{ $course->schedule_time }}
                                        </p>
                                    </div>
                                    
                                    <!-- Placeholder link: we will build this route next! -->
                                    <a href="{{ route('attendances.review', $course->id) }}" class="inline-flex items-center px-3 py-1.5 border border-blue-600 text-sm font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
    Review & Edit
</a>
                                </div>

                                <!-- Big Number Status Counters -->
                                <div class="flex justify-between divide-x divide-gray-100">
                                    <div class="flex-1 p-4 text-center hover:bg-green-50/50 transition cursor-default">
                                        <span class="block text-3xl font-black text-green-500">{{ $presents->count() }}</span>
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-1 block">Present</span>
                                    </div>

                                    <div class="flex-1 p-4 text-center hover:bg-yellow-50/50 transition cursor-default">
                                        <span class="block text-3xl font-black text-yellow-500">{{ $lates->count() }}</span>
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-1 block">Late</span>
                                    </div>

                                    <div class="flex-1 p-4 text-center hover:bg-red-50/50 transition cursor-default">
                                        <span class="block text-3xl font-black text-red-500">{{ $absents->count() }}</span>
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-1 block">Absent</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 bg-gray-50 rounded-lg border border-gray-200">
                                <p class="text-gray-500 italic">No attendance has been recorded for any classes today yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>