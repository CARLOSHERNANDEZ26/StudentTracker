<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Student List') }}
            </h2>
            <a href="{{ route('students.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-sm transition">
                Add New Student
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Student ID</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Section</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($students as $student)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-4 font-medium text-gray-900">{{ $student->student_id }}</td>
                                        <td class="py-3 px-4 text-gray-700">{{ $student->full_formatted_name }}</td>
                                        <td class="py-3 px-4 text-gray-600">{{ $student->section }}</td>
                                        <td class="py-3 px-4 flex items-center space-x-3">
                                            <a href="{{ route('students.edit', $student->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm transition">Edit</a>
                                            
                                            <div x-data="{ modalOpen: false }" class="inline-block">
                                                <button @click="modalOpen = true" type="button" class="text-red-500 hover:text-red-800 font-semibold text-sm transition">
                                                    Delete
                                                </button>

                                                <div x-show="modalOpen" 
                                                     style="display: none;" 
                                                     class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
                                                    
                                                    <div @click.away="modalOpen = false" 
                                                         x-transition
                                                         class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full mx-4 transform transition-all text-left whitespace-normal">
                                                        
                                                        <h3 class="text-lg font-bold text-gray-900 mb-2">Confirm Deletion</h3>
                                                        
                                                        <p class="text-sm text-gray-600 mb-6 whitespace-normal">
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
                    </div>
                    
                    @if($students->isEmpty())
                        <div class="text-center py-10 bg-gray-50 mt-4 rounded border border-dashed border-gray-300">
                            <p class="text-gray-500 italic">No students found. Add one to get started!</p>
                        </div>
                    @endif
                </div>

                @if($students->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $students->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>