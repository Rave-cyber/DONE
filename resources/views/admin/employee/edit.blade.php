@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Employee: {{ $employee->full_name }}</h1>

    <form action="{{ route('admin.employee.update', $employee) }}" method="POST" class="max-w-lg">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="first_name" class="block mb-2">First Name</label>
            <input type="text" name="first_name" id="first_name" 
                   class="w-full px-3 py-2 border rounded @error('first_name') border-red-500 @enderror" 
                   value="{{ old('first_name', $employee->first_name) }}" required>
            @error('first_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="last_name" class="block mb-2">Last Name</label>
            <input type="text" name="last_name" id="last_name" 
                   class="w-full px-3 py-2 border rounded @error('last_name') border-red-500 @enderror" 
                   value="{{ old('last_name', $employee->last_name) }}" required>
            @error('last_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block mb-2">Email</label>
            <input type="email" name="email" id="email" 
                   class="w-full px-3 py-2 border rounded @error('email') border-red-500 @enderror" 
                   value="{{ old('email', $employee->email) }}" required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="phone" class="block mb-2">Phone (Optional)</label>
            <input type="text" name="phone" id="phone" 
                   class="w-full px-3 py-2 border rounded" 
                   value="{{ old('phone', $employee->phone) }}">
            @error('phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="position" class="block mb-2">Position (Optional)</label>
            <input type="text" name="position" id="position" 
                   class="w-full px-3 py-2 border rounded" 
                   value="{{ old('position', $employee->position) }}">
            @error('position')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="hire_date" class="block mb-2">Hire Date (Optional)</label>
            <input type="date" name="hire_date" id="hire_date" 
                   class="w-full px-3 py-2 border rounded" 
                   value="{{ old('hire_date', $employee->hire_date) }}">
            @error('hire_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="block mb-2">Status</label>
            <select name="status" id="status" 
                    class="w-full px-3 py-2 border rounded @error('status') border-red-500 @enderror" 
                    required>
                <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>
                    Active
                </option>
                <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Update Employee
            </button>
            <a href="{{ route('admin.employee.index') }}" class="text-gray-600 hover:underline">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
