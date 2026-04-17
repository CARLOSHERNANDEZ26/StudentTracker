<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Record Class Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('attendances.store') }}">
                    @csrf
                    
                    <div class="mb-6 flex items-center">
                        <label for="attendance_date" class="block text-gray-700 text-sm font-bold mr-4">Select Date:</label>
                        <input type="date" name="attendance_date" id="attendance_date" value="{{ $date }}" required 
       onchange="window.location.href='{{ route('attendances.create') }}?date=' + this.value"
       class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('attendance_date') <p class="text-red-500 text-xs italic ml-2">{{ $message }}</p> @enderror
                    </div> 

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse mb-6">
                            <thead>
                                <tr>
                                    <th class="border-b py-2 px-4">Student ID</th>
                                    <th class="border-b py-2 px-4">Name</th>
                                    <th class="border-b py-2 px-4 text-center">Status</th>
                                </tr>
                            </thead>
                             <tbody>
    @foreach($students as $student)
        <tr class="hover:bg-gray-50">
            <td class="border-b py-3 px-4">{{ $student->student_id }}</td>
            
            <td class="border-b py-3 px-4">{{ $student->full_formated_name }}</td>
            
            <td class="border-b py-3 px-4 text-center">
                @if($existingAttendances->has($student->id))
                    <span class="bg-gray-200 text-gray-600 py-1 px-3 rounded-full text-xs font-bold uppercase">
                        Recorded: {{ $existingAttendances[$student->id] }}
                    </span>
                @else
                    <label class="inline-flex items-center mr-4 cursor-pointer">
                        <input type="radio" name="attendances[{{ $student->id }}]" value="Present" required class="text-green-500 focus:ring-green-400">
                        <span class="ml-2 text-green-700">Present</span>
                    </label>

                    <label class="inline-flex items-center mr-4 cursor-pointer">
                        <input type="radio" name="attendances[{{ $student->id }}]" value="Late" class="text-yellow-500 focus:ring-yellow-400">
                        <span class="ml-2 text-yellow-700">Late</span>
                    </label>

                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="attendances[{{ $student->id }}]" value="Absent" class="text-red-500 focus:ring-red-400">
                        <span class="ml-2 text-red-700">Absent</span>
                    </label>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>
                        </table>
                        
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                            Save Class Attendance
                        </button>
                    </div>
                    

                </form> 

            </div>
        </div>
    </div>
</x-app-layout>