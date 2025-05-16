@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h2 class="h5 mb-0">Supplier Management</h2>
                    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus mr-1"></i> Add New Supplier
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($supplier as $supplier)
                                <tr>
                                    <td>{{ $supplier->name }}</td>
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
                                    <td class="text-justify">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="btn btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- <a href="#" class="btn btn-{{ isset($supplier->status) && $supplier->status == 'active' ? 'warning' : 'success' }} toggle-status" 
                                               data-id="{{ $supplier->id }}" 
                                               data-status="{{ isset($supplier->status) ? $supplier->status : 'inactive' }}"
                                               title="{{ isset($supplier->status) && $supplier->status == 'active' ? 'Mark as Inactive' : 'Mark as Active' }}">
                                                <i class="fas fa-{{ isset($supplier->status) && $supplier->status == 'active' ? 'times' : 'check' }}"></i>
                                            </a> -->
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

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.toggle-status').on('click', function(e) {
            e.preventDefault();
            const button = $(this);
            const supplierId = button.data('id');
            const currentStatus = button.data('status');
            const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
            
            if (confirm(`Are you sure you want to mark this supplier as ${newStatus}?`)) {
                $.ajax({
                    url: `/admin/suppliers/${supplierId}/toggle-status`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        status: newStatus
                    },
                    success: function(response) {
                        // Update the button appearance
                        button.removeClass('btn-success btn-warning')
                              .addClass(newStatus === 'active' ? 'btn-warning' : 'btn-success');
                        
                        button.attr('title', newStatus === 'active' ? 'Mark as Inactive' : 'Mark as Active');
                        button.find('i').removeClass('fa-check fa-times')
                                        .addClass(newStatus === 'active' ? 'fa-times' : 'fa-check');
                        
                        button.closest('tr').find('td:nth-child(5) .badge')
                              .removeClass('badge-success badge-danger')
                              .addClass(newStatus === 'active' ? 'badge-success' : 'badge-danger')
                              .text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
                                
                        // Update data attribute
                        button.data('status', newStatus);
                        
                        alert(response.message);
                    },
                    error: function(xhr) {
                        alert('Error occurred while updating supplier status.');
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
@endpush
