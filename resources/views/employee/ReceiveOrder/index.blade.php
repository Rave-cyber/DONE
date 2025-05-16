@extends('layouts.employee-layout')

@section('title', 'Receive Orders')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h2 class="h5 mb-0">
                        <i class="fas fa-clipboard-check mr-2"></i>Receive Orders
                    </h2>
                    <a href="{{ route('employee.receive-orders.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus-circle mr-1"></i> New Receive Order
                    </a>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    <!-- Stats Summary -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-light border-0 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-muted mb-1 small">Total Orders</h6>
                                            <h4 class="font-weight-bold mb-0">{{ $receiveOrders->total() }}</h4>
                                        </div>
                                        <div class="icon-shape rounded-circle bg-light text-primary p-3">
                                            <i class="fas fa-clipboard-list"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive border rounded">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="pl-4">RO Number</th>
                                    <th>Supplier</th>
                                    <th>Date Received</th>
                                    <th>Total Items</th>
                                    <th>Status</th>
                                    <th class="text-right pr-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($receiveOrders as $order)
                                <tr>
                                    <td class="pl-4">{{ $order->order_number }}</td>
                                    <td>{{ $order->supplier->name }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>{{ $order->items->sum('quantity') }}</td>
                                    <td>
                                        <span class="badge badge-pill 
                                            @if($order->status === 'completed') badge-success
                                            @elseif($order->status === 'pending') badge-warning
                                            @else badge-secondary
                                            @endif">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="text-right pr-4">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('employee.receive-orders.show', $order->id) }}" class="btn btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <!-- <a href="{{ route('employee.receive-orders.edit', $order->id) }}" class="btn btn-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a> -->
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                            <p class="text-muted mb-3">No receive orders found</p>
                                            <a href="{{ route('employee.receive-orders.create') }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-plus mr-1"></i> Add Receive Order
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($receiveOrders->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="pagination-info text-muted">
                            Showing {{ $receiveOrders->firstItem() ?? 0 }} to {{ $receiveOrders->lastItem() ?? 0 }} of {{ $receiveOrders->total() }} orders
                        </div>
                        <div class="pagination-controls">
                            {{ $receiveOrders->appends(request()->query())->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Set pagination limit to 8 items per page
    $(function () {
        // Note: The actual pagination limit should be set in the controller
        // For reference, update ReceiveOrderController.php with:
        // $receiveOrders = ReceiveOrder::with('supplier')->latest()->paginate(8);
    });
</script>
@endpush
@endsection