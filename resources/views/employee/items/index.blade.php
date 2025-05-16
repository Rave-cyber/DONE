@extends('layouts.employee-layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h2 class="h5 mb-0">Inventory Management</h2>
                    <a href="{{ route('employee.items.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus mr-1"></i> Add New Item
                    </a>
                </div>
                
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="pl-4">ID</th>
                                    <th>Item Name</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th class="text-right pr-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inventoryitem as $inventoryitem)
                                <tr>
                                    <td class="pl-4">{{ $inventoryitem->id }}</td>
                                    <td>{{ $inventoryitem->name }}</td>
                                    <td>{{ $inventoryitem->category }}</td>
                                    <td>{{ $inventoryitem->quantity }}</td>
                                    <td>@if($inventoryitem->latest_price)
                                            ₱{{ number_format($inventoryitem->latest_price, 2) }}
                                        @else
                                    <span class="text-muted">N/A</span>@endif
                                </td>
                                    <td>
                                        <span class="badge 
                                            @if($inventoryitem->status == 'In Stock') badge-success
                                            @elseif($inventoryitem->status == 'Low Stock') badge-warning
                                            @else badge-danger
                                            @endif">
                                            {{ $inventoryitem->status }}
                                        </span>
                                    </td>
                                    <td class="text-right pr-4">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('employee.items.edit', $inventoryitem->id) }}" class="btn btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- <form action="{{ route('employee.items.destroy', $inventoryitem->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form> -->
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection