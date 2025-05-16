@extends('layouts.admin')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(137.15deg, rgba(23, 232, 255, 0.00) 0%, rgba(23, 232, 255, 0.18) 86.00000143051147%, rgba(23, 232, 255, 0.20) 100%), 
                              linear-gradient(to left, rgba(7, 156, 214, 0.20), rgba(7, 156, 214, 0.20)), 
                              linear-gradient(119.69deg, rgba(93, 141, 230, 0.00) 0%, rgba(142, 176, 239, 0.10) 45.691317319869995%, rgba(36, 89, 188, 0.20) 96.88477516174316%), 
                              linear-gradient(to left, rgba(47, 53, 109, 0.20), rgba(47, 53, 109, 0.20));">
    <div class="w-full min-h-screen flex flex-col">



        <!-- Content area -->
        <div class="px-4 py-2">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-xl font-semibold text-white">Employee Management</h1>
                <!-- <a href="{{ route('admin.employee.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                    Add New Employee
                </a> -->
            </div>

            @if(session('success'))
                <div class="bg-green-800 text-green-100 px-4 py-2 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Employee Table -->
            <div class="bg-gray-800 bg-opacity-80 rounded-lg overflow-hidden">
                <table class="w-full text-white">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium">Name</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Email</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Position</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($employees as $employee)
                        <tr class="hover:bg-gray-700">
                            <td class="px-4 py-3 text-sm">{{ $employee->getFullName() }}</td>
                            <td class="px-4 py-3 text-sm text-gray-300">{{ $employee->email }}</td>
                            <td class="px-4 py-3 text-sm text-gray-300">{{ $employee->position ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $employee->status == 'active' ? 'bg-green-900 text-green-100' : 'bg-red-900 text-red-100' }}">
                                    {{ ucfirst($employee->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex space-x-3">
                                    <a href="{{ route('admin.employee.edit', $employee) }}" 
                                       class="text-blue-400 hover:text-blue-300">
                                        Edit
                                    </a>
                                    <!-- <form action="{{ route('admin.employee.destroy', $employee) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300">
                                            Delete
                                        </button>
                                    </form> -->
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 bg-gray-800 bg-opacity-80 rounded-lg p-3">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    html, body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    overflow-x: hidden;
}

    .pagination {
        display: flex;
        justify-content: center;
    }
    .page-item.active .page-link {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
    .page-link {
        color:rgb(0, 81, 202);
        background-color: #1f2937;
        border: 1px solid #374151;
        margin: 0 2px;
    }
    .page-link:hover {
        color:rgb(187, 0, 0);
        background-color: #374151;
        border-color: #4b5563;
    }
</style>
@endsection