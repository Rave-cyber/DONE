@extends('layouts.employee-layout')

@section('title', 'Stock In Records')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h2 class="h5 mb-0">
                        <i class="fas fa-arrow-down mr-2"></i>Stock In Records
                    </h2>
                    <a href="{{ route('employee.stock-in.form') }}" class="btn btn-light btn-sm text-primary">
                        <i class="fas fa-plus-circle mr-1"></i> New Transaction
                    </a>
                </div>
                
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="pl-4">Item</th>
                                    <th>Supplier</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Value</th>
                                    <th>Reason</th>
                                    <th>Date</th>
                                    <th class="text-right pr-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stockIns as $stock)
                                <tr>
                                    <td class="pl-4">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{ $stock->item->name ?? 'N/A' }}</strong>
                                                @if($stock->item->sku ?? false)
                                                <div class="text-muted small">SKU: {{ $stock->item->sku }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $stock->supplier->name ?? 'N/A' }}</td>
                                    <td>{{ $stock->quantity }} pcs</td>
                                    <td>₱{{ number_format($stock->price, 2) }}</td>
                                    <td>₱{{ number_format($stock->quantity * $stock->price, 2) }}</td>
                                    <td>{{ $stock->reason ?? '-' }}</td>
                                    <td>{{ $stock->created_at->format('M d, Y h:i A') }}</td>
                                    <td class="text-right pr-4">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="#" class="btn btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-box-open fa-2x text-muted mb-3"></i>
                                        <p class="text-muted">No stock-in records found</p>
                                        <a href="{{ route('employee.stock-in.form') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus mr-1"></i> Add Stock In
                                        </a>
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

    @if($stockIns->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $stockIns->links() }}
    </div>
    @endif
</div>
@endsection