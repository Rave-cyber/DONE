@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Add New Employee</h1>

    <form action="{{ route('admin.employee.store') }}" method="POST" class="max-w-lg">
        @csrf
        <div class="mb-4">
            <label for="first_name" class="block mb-2">First Name</label>
            <input type="text" name="first_name" id="first_name" 
                   class="w-full px-3 py-2 border rounded" 
                   value="{{ old('first_name') }}" required>
            @error('first_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="last_name" class="block mb-2">Last Name</label>
            <input type="text" name="last_name" id="last_name" 
                   class="w-full px-3 py-2 border rounded" 
                   value="{{ old('last_name') }}" required>
            @error('last_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block mb-2">Email</label>
            <input type="email" name="email" id="email" 
                   class="w-full px-3 py-2 border rounded" 
                   value="{{ old('email') }}" required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="phone" class="block mb-2">Phone (Optional)</label>
            <input type="text" name="phone" id="phone" 
                   class="w-full px-3 py-2 border rounded" 
                   value="{{ old('phone') }}">
        </div>

        <div class="mb-4">
            <label for="position" class="block mb-2">Position (Optional)</label>
            <input type="text" name="position" id="position" 
                   class="w-full px-3 py-2 border rounded" 
                   value="{{ old('position') }}">
        </div>

        <div class="mb-4">
            <label for="hire_date" class="block mb-2">Hire Date (Optional)</label>
            <input type="date" name="hire_date" id="hire_date" 
                   class="w-full px-3 py-2 border rounded" 
                   value="{{ old('hire_date') }}">
        </div>

        <!-- <div class="mb-4">
            <label for="status" class="block mb-2">Status</label>
            <select name="status" id="status" class="w-full px-3 py-2 border rounded" required>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div> -->
     <div class="flex justify-end space-x-4 mt-6">
    <a href="{{ route('admin.employee.index') }}" 
       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
        Cancel
    </a>
    <button type="submit" 
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        Create Employee
    </button>
</div>
    </form>
</div>
@endsection