@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Manage Service Prices</h1>
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.prices.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="wash_base_price">Wash Price per Kilogram (₱/kg)</label>
                    <input id="wash_base_price" type="number" step="0.01" min="0" 
                           name="wash_base_price" value="{{ old('wash_base_price', $servicePrices['Wash']->base_price ?? 10) }}" 
                           class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="fold_base_price">Fold Price per Kilogram (₱/kg)</label>
                    <input id="fold_base_price" type="number" step="0.01" min="0" 
                           name="fold_base_price" value="{{ old('fold_base_price', $servicePrices['Fold']->base_price ?? 6) }}" 
                           class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="ironing_base_price">Ironing Price per Kilogram (₱/kg)</label>
                    <input id="ironing_base_price" type="number" step="0.01" min="0" 
                           name="ironing_base_price" value="{{ old('ironing_base_price', $servicePrices['Ironing']->base_price ?? 8) }}" 
                           class="form-control" required>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Prices</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>

<style>
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }
    .form-control {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 4px;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 4px;
        text-decoration: none;
    }
    .btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: none;
    }
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    .card-body {
        padding: 1.5rem;
    }
    .card-footer {
        padding: 1rem;
        background-color: #f8f9fa;
        border-top: 1px solid #ddd;
    }
</style>
@endsection
