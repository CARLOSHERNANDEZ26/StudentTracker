<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Attendance Report for {{ $reportDate }}</h3>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="border-b py-2 px-4">Student ID</th>
                            <th class="border-b py-2 px-4">Name</th>
                          <th class="border-b py-2 px-4">Present</th>
                            <th class="border-b py-2 px-4">Late</th>
                            <th class="border-b py-2 px-4">Absent</th>
                            <th class="border-b py-2 px-4">Attendance %</th>
                        </tr>
                    </thead>
                    <tbody>
    @foreach($students as $student)
        @php
            // Use the Eloquent relationship we set up in Step 1
            $totalDays = $student->attendances->count();
            $totalPresent = $student->attendances->where('status', 'Present')->count();
            $totalLate = $student->attendances->where('status', 'Late')->count();
            $totalAbsent = $student->attendances->where('status', 'Absent')->count();
            
            $percentage = $totalDays > 0 ? round(($totalPresent / $totalDays) * 100, 1) : 0;
            $isAtRisk = $percentage < 75 && $totalDays > 0;
        @endphp

        <tr class="{{ $isAtRisk ? 'bg-red-50' : '' }}">
            <td class="border-b py-3 px-4">{{ $student->student_id }}</td>
            <td class="border-b py-3 px-4">{{ $student->full_formated_name }}</td>
            <td class="border-b py-3 px-4 text-green-600">{{ $totalPresent }}</td>
            <td class="border-b py-3 px-4 text-yellow-600">{{ $totalLate }}</td>
            <td class="border-b py-3 px-4 text-red-600">{{ $totalAbsent }}</td>
            <td class="border-b py-3 px-4">
                <span class="{{ $isAtRisk ? 'text-red-600 font-bold' : '' }}">
                    {{ $percentage }}%
                </span>
            </td>
        </tr>
    @endforeach
</tbody>
                </table>
                @if($students->isEmpty())
                    <p class="text-gray-500 mt-4 text-center">No Students found. Add some attendance records to see the report!</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>