@extends('layouts.employee-layout')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Add New Inventory Item</h5>
                    <a href="{{ route('employee.items.index') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>
                
                <div class="card-body p-4">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    <form action="{{ route('employee.items.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Item Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="">Select Category</option>
                                <option value="Cleaning Supplies" {{ old('category') == 'Cleaning Supplies' ? 'selected' : '' }}>
                                    Cleaning Supplies
                                </option>
                                <option value="Equipment" {{ old('category') == 'Equipment' ? 'selected' : '' }}>
                                    Equipment
                                </option>
                                <option value="Packaging" {{ old('category') == 'Packaging' ? 'selected' : '' }}>
                                    Packaging
                                </option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Price field commented out -->
                        <!-- <div class="mb-3">
                            <label for="price" class="form-label">Price (₱)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                      id="price" name="price" min="0" step="0.01" value="{{ old('price', 0) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> -->

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="In Stock" {{ old('status') == 'In Stock' ? 'selected' : '' }}>
                                    In Stock
                                </option>
                                <option value="Low Stock" {{ old('status') == 'Low Stock' ? 'selected' : '' }}>
                                    Low Stock
                                </option>
                                <option value="Out of Stock" {{ old('status') == 'Out of Stock' ? 'selected' : '' }}>
                                    Out of Stock
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('employee.items.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush