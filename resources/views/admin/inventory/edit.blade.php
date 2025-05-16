@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Edit Inventory Item</h5>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    <form id="inventoryForm" action="{{ route('admin.inventory.update', $inventoryItem->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.inventory._form')
                        
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary me-2">
                                Cancel
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