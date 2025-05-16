@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Add New Inventory Item</h2>
        </div>
        
        <div class="card-body">
            <form action="{{ route('admin.inventory.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name">Item Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control @error('category') is-invalid @enderror" 
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
                
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                           id="quantity" name="quantity" min="0" value="{{ old('quantity', 0) }}" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="price">Price ($)</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                           id="price" name="price" min="0" step="0.01" value="{{ old('price', 0) }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control @error('status') is-invalid @enderror" 
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
                
                <div class="form-group text-right">
                    <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary mr-2">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Save Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .card {
        border-radius: 10px;
    }
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    .form-control {
        border-radius: 5px;
    }
</style>
@endpush