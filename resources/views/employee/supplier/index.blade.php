@extends('layouts.employee-layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h2 class="h5 mb-0">Supplier List</h2>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <!-- <th class="text-center">Details</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($supplier as $supplier)
                                <tr>
                                    <td class="font-weight-bold">{{ $supplier->name }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>{{ $supplier->address }}</td>
                                    <td>
                                        @if(isset($supplier->status))
                                            <span class="badge badge-{{ $supplier->status == 'active' ? 'success' : 'danger' }} px-3 py-2">
                                                {{ ucfirst($supplier->status) }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary px-3 py-2">Unknown</span>
                                        @endif
                                    </td>
                                    <!-- <td class="text-center">
                                        <a href="{{ route('employee.supplier.show', $supplier->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td> -->
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

@push('styles')
<style>
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .card-header {
        background-color: #079CD6;
    }
    
    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .badge {
        font-weight: 500;
        border-radius: 30px;
    }
    
    .btn-group .btn {
        border-radius: 4px;
        margin-right: 5px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
@endpush


