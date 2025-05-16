@extends('layouts.employee-layout')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-boxes me-2"></i>Stock In from Receive Order</h5>
                    <a href="{{ route('employee.stock_in_index') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-list me-1"></i> View Stock History
                    </a>
                </div>
                
                <div class="card-body p-4">
                    {{-- Flash Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($receiveOrders->isNotEmpty())
                    <form method="GET" action="{{ route('employee.stock-in.form') }}" class="mb-4">
                        <div class="mb-3">
                            <label for="receive_order_id" class="form-label fw-bold">Select Receive Order with Remaining Stock</label>
                            <select name="receive_order_id" onchange="this.form.submit()" class="form-select form-select-lg">
                                <option value="">-- Select an order --</option>
                                @foreach($receiveOrders as $ro)
                                    @php
                                        $totalRemaining = 0;
                                        foreach($ro->items as $item) {
                                            $totalRemaining += max(0, $item->quantity - $item->stocked_in_quantity);
                                        }
                                    @endphp
                                    
                                    @if($totalRemaining > 0)
                                    <option value="{{ $ro->id }}" {{ request('receive_order_id') == $ro->id ? 'selected' : '' }}>
                                        Order #{{ $ro->order_number }} ({{ $ro->supplier->name }}) - {{ $totalRemaining }} items remaining
                                    </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </form>
                    @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>No receive orders available for stock in at this time.
                    </div>
                    @endif

                    @if($selectedOrder)
                    <div class="card border-primary mb-4">
                        <div class="card-header bg-light text-primary fw-bold">
                            <i class="fas fa-clipboard-list me-2"></i>Items to Stock In - Order #{{ $selectedOrder->order_number }}
                        </div>
                        <div class="card-body">
                            {{-- Display items from selected receive order --}}
                            <form action="{{ route('employee.stock-in.from-ro.submit', $selectedOrder->id) }}" method="POST">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Item</th>
                                                <th class="text-center">Ordered Qty</th>
                                                <th class="text-center">Already Stocked</th>
                                                <th class="text-center">Remaining</th>
                                                <th class="text-center">Stock In Now</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $hasRemainingItems = false; @endphp
                                            @foreach($selectedOrder->items as $roItem)
                                                @php
                                                    $remaining = $roItem->quantity - $roItem->stocked_in_quantity;
                                                @endphp
                                                @if($remaining > 0)
                                                @php $hasRemainingItems = true; @endphp
                                                <tr>
                                                    <td class="align-middle">{{ $roItem->inventoryItem->name }}</td>
                                                    <td class="text-center align-middle">{{ $roItem->quantity }}</td>
                                                    <td class="text-center align-middle">{{ $roItem->stocked_in_quantity }}</td>
                                                    <td class="text-center align-middle">
                                                        <span class="badge bg-primary">{{ $remaining }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="number" name="items[{{ $roItem->id }}][quantity]" 
                                                                class="form-control" max="{{ $remaining }}" min="1" 
                                                                value="{{ $remaining }}" required>
                                                            <input type="hidden" name="items[{{ $roItem->id }}][id]" value="{{ $roItem->id }}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                            
                                            @if(!$hasRemainingItems)
                                            <tr>
                                                <td colspan="5" class="text-center py-3">
                                                    <div class="alert alert-info mb-0">
                                                        All items from this order have been stocked in.
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                
                                @if($hasRemainingItems)
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Stock In Selected Items
                                    </button>
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
