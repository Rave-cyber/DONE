@extends('layouts.employee-layout')

@section('title', 'Receive Order Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h2 class="h5 mb-0">
                        <i class="fas fa-clipboard-list mr-2"></i>Receive Order #{{ $receiveOrder->order_number }}
                    </h2>
                    <a href="{{ route('employee.receive-orders.index') }}" class="btn btn-light btn-sm text-primary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to List
                    </a>
                </div>
                
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="info-card bg-light p-3 rounded">
                                <h5 class="text-primary"><i class="fas fa-truck mr-2"></i>Supplier</h5>
                                <p class="mb-0">{{ $receiveOrder->supplier->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card bg-light p-3 rounded">
                                <h5 class="text-primary"><i class="fas fa-info-circle mr-2"></i>Status</h5>
                                <span class="badge 
                                    @if($receiveOrder->status === 'Completed') badge-success
                                    @elseif($receiveOrder->status === 'Pending') badge-warning
                                    @else badge-secondary
                                    @endif">
                                    {{ $receiveOrder->status }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card bg-light p-3 rounded">
                                <h5 class="text-primary"><i class="fas fa-money-bill-wave mr-2"></i>Total Price</h5>
                                <p class="mb-0">₱{{ number_format($receiveOrder->total_price, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card border-primary mb-4">
                        <div class="card-header bg-light-primary text-primary font-weight-bold">
                            <i class="fas fa-boxes mr-2"></i>Received Items
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th class="pl-4">Item</th>
                                            <th>Quantity</th>
                                            <th>Stocked In</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($receiveOrder->items as $item)
                                        <tr>
                                            <td class="pl-4">{{ $item->inventoryItem->name ?? 'N/A' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->stocked_in_quantity ?? 0 }}</td>
                                            <td>₱{{ number_format($item->unit_price, 2) }}</td>
                                            <td>₱{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr>
                                            <td colspan="4" class="text-right font-weight-bold">Order Total:</td>
                                            <td class="font-weight-bold">₱{{ number_format($receiveOrder->total_price, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .info-card {
        border-left: 4px solid #079CD6;
        height: 100%;
    }
    .table {
        background-color: #fff;
    }
    .table thead th {
        border-top: none;
        font-weight: 600;
    }
    .table tbody tr:hover {
        background-color: rgba(7, 156, 214, 0.05);
    }
</style>
@endsection