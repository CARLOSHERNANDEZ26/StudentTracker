<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Student List') }}
            </h2>
            <a href="{{ route('students.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New Student
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="border-b py-2 px-4">Student ID</th>
                            <th class="border-b py-2 px-4">Name</th>
                            <th class="border-b py-2 px-4">Section</th>
                            <th class="border-b py-2 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td class="border-b py-2 px-4">{{ $student->student_id }}</td>
                                <td class="border-b py-2 px-4">{{ $student->full_formatted_name }}</td>
                                <td class="border-b py-2 px-4">{{ $student->section }}</td>
                                <td class="border-b py-2 px-4">
                                <a href="{{ route('students.edit', $student->id) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                      <div x-data="{ modalOpen: false }" class="inline-block ml-2">
    
    <button @click="modalOpen = true" type="button" class="text-red-500 hover:text-red-800 font-semibold">
        Delete
    </button>

    <div x-show="modalOpen" 
         style="display: none;" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
        
        <div @click.away="modalOpen = false" 
             x-transition
             class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full mx-4 transform transition-all text-left">
            
            <h3 class="text-lg font-bold text-gray-900 mb-2">Confirm Deletion</h3>
            
            <p class="text-sm text-gray-600 mb-6">
                Are you sure you want to delete <strong>{{ $student->full_formatted_name }}</strong>? This action cannot be undone.
            </p>
            
            <div class="flex justify-end space-x-3">
                <button @click="modalOpen = false" type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 font-semibold transition">
                    Cancel
                </button>
                
                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-semibold transition">
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @if($students->isEmpty())
                    <p class="text-gray-500 mt-4 text-center">No students found. Add one to get started!</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>