<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('students.update', $student->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="student_id" class="block text-gray-700 text-sm font-bold mb-2">Student ID</label>
                        <input type="text" name="student_id" id="student_id" value="{{ old('student_id', $student->student_id) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('student_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>
    
                   <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
    <div>
        <label for="last_name" class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $student->last_name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        @error('last_name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $student->first_name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        @error('first_name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="middle_name" class="block text-gray-700 text-sm font-bold mb-2">Middle Name</label>
        <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name', $student->middle_name ?? '') }}" placeholder="(Optional)" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>
</div>

<div class="mb-6">
    <label for="section" class="block text-gray-700 text-sm font-bold mb-2">Section</label>
    <input type="text" name="section" id="section" value="{{ old('section', $student->section ?? '') }}" placeholder="e.g., BSIT 3-A" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    @error('section') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
</div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Save Student
                        </button>
                        <a href="{{ route('students.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>