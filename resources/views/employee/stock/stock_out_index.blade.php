@extends('layouts.employee-layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h2 class="h5 mb-0">
                        <i class="fas fa-arrow-circle-down mr-2"></i>Stock Out Transactions
                    </h2>
                    <a href="{{ route('employee.stock-out.form') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus-circle mr-1"></i> New Stock Out
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

                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-light border-0 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-muted mb-1 small">Total Transactions</h6>
                                            <h4 class="font-weight-bold mb-0">{{ $stockOuts->total() }}</h4>
                                        </div>
                                        <div class="icon-shape rounded-circle bg-light text-primary p-3">
                                            <i class="fas fa-exchange-alt"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light border-0 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-muted mb-1 small">Today's Stock Outs</h6>
                                            <h4 class="font-weight-bold mb-0">
                                                {{ $stockOuts->where('created_at', '>=', \Carbon\Carbon::today())->count() }}
                                            </h4>
                                        </div>
                                        <div class="icon-shape rounded-circle bg-light text-success p-3">
                                            <i class="fas fa-calendar-day"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light border-0 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-muted mb-1 small">Unique Items</h6>
                                            <h4 class="font-weight-bold mb-0">
                                                {{ $stockOuts->unique('item_id')->count() }}
                                            </h4>
                                        </div>
                                        <div class="icon-shape rounded-circle bg-light text-danger p-3">
                                            <i class="fas fa-box-open"></i>
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
                                    <th class="pl-4">Item</th>
                                    <th>Quantity</th>
                                    <th>Reason</th>
                                    <th>Date & Time</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stockOuts as $stock)
                                <tr>
                                    <td class="pl-4">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2">
                                                <span class="rounded-circle bg-light p-2">
                                                    <i class="fas fa-box text-primary"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <strong>{{ $stock->item->name ?? 'N/A' }}</strong>
                                                @if($stock->item->sku ?? false)
                                                <div class="text-muted small">SKU: {{ $stock->item->sku }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-danger">-{{ $stock->quantity }}</span>
                                        <span class="text-muted ml-1">pcs</span>
                                    </td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                              data-toggle="tooltip" title="{{ $stock->reason }}">
                                            {{ $stock->reason }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="font-weight-medium">{{ $stock->created_at->format('M d, Y') }}</div>
                                        <div class="text-muted small">{{ $stock->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $stock->user->name ?? 'System' }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                            <p class="text-muted mb-3">No stock out transactions found</p>
                                            <a href="{{ route('employee.stock-out.form') }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus mr-1"></i> Add Stock Out
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($stockOuts->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $stockOuts->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush
@endsection