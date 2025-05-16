@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h2 class="h5 mb-0">Inventory Management</h2>
                    <a href="{{ route('admin.inventory.create') }}" class="btn btn-success btn-sm">
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
                                @foreach($inventoryItems as $item)
                                <tr>
                                    <td class="pl-4">{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>₱{{ number_format($item->price, 2) }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($item->status == 'In Stock') badge-success
                                            @elseif($item->status == 'Low Stock') badge-warning
                                            @else badge-danger
                                            @endif">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="text-right pr-4">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.inventory.edit', $item->id) }}" class="btn btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .card {
        border: none;
        border-radius: 0.375rem;
    }
    .card-header {
        border-radius: 0.375rem 0.375rem 0 0 !important;
    }
    .table th {
        font-weight: 600;
        border-top: none;
    }
    .table td, .table th {
        vertical-align: middle;
    }
    .btn-group {
        white-space: nowrap;
    }
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
    .alert {
        border-radius: 0.375rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').alert('close');
        }, 3000);
    });
</script>
@endpush