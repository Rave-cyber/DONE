@extends('layouts.employee-layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h2 class="h5 mb-0">
                        <i class="fas fa-arrow-alt-circle-down mr-2"></i>New Stock Out Transaction
                    </h2>
                    <a href="{{ route('employee.stock_out_index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-list mr-1"></i> View All Stock Out
                    </a>
                </div>
                
                <div class="card-body">
                    {{-- Success and Error Message Alerts --}}
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

                    {{-- Stock Out Form --}}
                    <form action="{{ route('employee.stock-out') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="item_id" class="font-weight-bold">
                                        <i class="fas fa-box mr-1 text-primary"></i>Select Item
                                    </label>
                                    <select name="item_id" id="item_id" class="form-control border-primary" required>
                                        <option value="">-- Select Item --</option>
                                        @foreach($items as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }} (Current Stock: {{ $item->quantity }} pcs)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('item_id') 
                                        <div class="text-danger small mt-1">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="quantity" class="font-weight-bold">
                                        <i class="fas fa-sort-numeric-down mr-1 text-primary"></i>Quantity to Stock Out
                                    </label>
                                    <div class="input-group">
                                        <input type="number" name="quantity" id="quantity" class="form-control border-primary" 
                                               min="1" required value="{{ old('quantity', 1) }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">pcs</span>
                                        </div>
                                    </div>
                                    @error('quantity') 
                                        <div class="text-danger small mt-1">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="reason" class="font-weight-bold">
                                <i class="fas fa-clipboard-list mr-1 text-primary"></i>Reason for Stock Out
                            </label>
                            <textarea name="reason" id="reason" rows="3" class="form-control border-primary" 
                                      required placeholder="Enter detailed reason for removing stock...">{{ old('reason') }}</textarea>
                            @error('reason') 
                                <div class="text-danger small mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="alert alert-warning mb-4">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Important:</strong> Stock out transactions cannot be reversed. Please ensure all information is correct.
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('employee.stock_out_index') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-times mr-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="fas fa-arrow-circle-down mr-1"></i>Process Stock Out
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
