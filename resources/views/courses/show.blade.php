<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.default.css" rel="stylesheet">
        
        <div class="flex justify-between items-center mt-2">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-tight">
                {{ $course->course_code }}: {{ $course->course_name }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-blue-600 transition">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between bg-gradient-to-r from-blue-50 to-white">
                    <div>
                        <h3 class="text-sm font-bold text-blue-500 uppercase tracking-widest mb-1">Class Details</h3>
                        <p class="text-xl font-black text-slate-800">{{ $course->schedule_days }} <span class="text-slate-400 mx-2">|</span> {{ $course->schedule_time }}</p>
                    </div>
                    
                    <div class="mt-4 md:mt-0 w-full md:w-1/2 lg:w-1/3">
                        <form action="{{ route('courses.enroll', $course->id) }}" method="POST" class="flex items-center gap-3">
                            @csrf
                            <div class="flex-grow">
                                <select name="student_ids[]" id="searchable-student-select" multiple required placeholder="Search and select multiple students...">
                                    <option value="">Search to enroll a student...</option>
                                    @foreach($availableStudents as $student)
                                        <option value="{{ $student->id }}">{{ $student->full_formatted_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-md text-sm font-bold hover:bg-blue-700 transition shadow-sm h-[42px] active:scale-95">
                                Enroll
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div x-data="{ activeTab: 'attendance' }" class="bg-white shadow-sm sm:rounded-xl border border-gray-200 overflow-hidden">
                
                <div class="border-b border-gray-200 bg-gray-50 px-6">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button @click="activeTab = 'attendance'" 
                                :class="activeTab === 'attendance' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                            <span class="mr-2">📋</span> Record Attendance
                        </button>
                        
                        <button @click="activeTab = 'roster'" 
                                :class="activeTab === 'roster' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors">
                            <span class="mr-2">👥</span> Manage Roster ({{ $course->students->count() }})
                        </button>
                    </nav>
                </div>

                <div x-show="activeTab === 'attendance'" class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Daily Attendance</h3>
                            <p class="text-sm text-gray-500">Mark or edit attendance for enrolled students below.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('attendances.store') }}">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        
                        <div class="mb-6 bg-slate-50 p-4 rounded-lg border border-slate-200 inline-block">
                            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Date of Class</label>
                            <input type="date" name="attendance_date" value="{{ date('Y-m-d') }}" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-medium text-slate-700" required>
                        </div>

                        @if($course->students->count() > 0)
                            <div class="overflow-x-auto border border-gray-200 rounded-lg mb-6">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-slate-800 text-white">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Student Name</th>
                                            <th class="px-6 py-3 text-center text-xs font-bold text-green-400 uppercase tracking-wider">Present</th>
                                            <th class="px-6 py-3 text-center text-xs font-bold text-yellow-400 uppercase tracking-wider">Late</th>
                                            <th class="px-6 py-3 text-center text-xs font-bold text-red-400 uppercase tracking-wider">Absent</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($course->students as $student)
                                            @php
                                                // Check if attendance already exists for today
                                                $status = $todaysAttendance[$student->id] ?? null;
                                            @endphp
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                                    {{ $student->full_formatted_name }}
                                                    
                                                    @if($status == 'Present')
                                                        <span class="ml-2 inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">Saved: Present</span>
                                                    @elseif($status == 'Late')
                                                        <span class="ml-2 inline-flex items-center rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-800">Saved: Late</span>
                                                    @elseif($status == 'Absent')
                                                        <span class="ml-2 inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">Saved: Absent</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center bg-green-50/30">
                                                    <input type="radio" name="attendances[{{ $student->id }}]" value="Present" {{ $status == 'Present' ? 'checked' : '' }} class="h-5 w-5 text-green-600 focus:ring-green-500 cursor-pointer" required>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center bg-yellow-50/30">
                                                    <input type="radio" name="attendances[{{ $student->id }}]" value="Late" {{ $status == 'Late' ? 'checked' : '' }} class="h-5 w-5 text-yellow-500 focus:ring-yellow-500 cursor-pointer" required>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center bg-red-50/30">
                                                    <input type="radio" name="attendances[{{ $student->id }}]" value="Absent" {{ $status == 'Absent' ? 'checked' : '' }} class="h-5 w-5 text-red-600 focus:ring-red-500 cursor-pointer" required>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 shadow-md transition active:scale-95">
                                    Save Today's Attendance
                                </button>
                            </div>
                        @else
                            <div class="text-center py-12 text-gray-500 italic border-2 border-dashed border-gray-200 rounded-lg">
                                No students are enrolled in this class yet. Use the search bar above to add them.
                            </div>
                        @endif
                    </form>
                </div>

                <div x-show="activeTab === 'roster'" style="display: none;" class="p-6">
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Student ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Full Name</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($course->students as $student)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $student->student_id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-700">{{ $student->full_formatted_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                            
                                            <div x-data="{ unenrollModal: false }" class="inline-block text-left">
                                                <button @click="unenrollModal = true" type="button" class="text-red-600 hover:text-red-900 font-bold bg-red-50 px-3 py-1 rounded-md border border-red-100 transition">
                                                    Unenroll
                                                </button>

                                                <div x-show="unenrollModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm px-4">
                                                    <div @click.away="unenrollModal = false" 
                                                         x-transition:enter="transition ease-out duration-300"
                                                         x-transition:enter-start="opacity-0 scale-95"
                                                         x-transition:enter-end="opacity-100 scale-100"
                                                         class="bg-white rounded-xl shadow-2xl p-6 max-w-sm w-full border border-slate-200 text-left whitespace-normal">
                                                        
                                                        <div class="flex items-center gap-3 mb-4 text-red-600">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                            <h3 class="text-lg font-extrabold tracking-tight">Confirm Unenrollment</h3>
                                                        </div>
                                                        <p class="text-sm text-slate-600 mb-6 leading-relaxed whitespace-normal">
                                                            Are you sure you want to remove <strong>{{ $student->full_formatted_name }}</strong> from this class?
                                                        </p>
                                                        <div class="flex justify-end space-x-3">
                                                            <button @click="unenrollModal = false" type="button" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 font-bold text-sm transition">Cancel</button>
                                                            <form action="{{ route('courses.unenroll', [$course->id, $student->id]) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-bold text-sm shadow-sm transition active:scale-95">Yes, Unenroll</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-10 text-center text-gray-500 italic border-2 border-dashed border-gray-200 rounded-lg">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        new TomSelect("#searchable-student-select",{
            plugins: ['remove_button'], 
            create: false,
            sortField: { field: "text", direction: "asc" },
            maxOptions: null
        });
    });
</script>
</x-app-layout>