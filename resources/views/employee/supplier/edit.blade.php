@extends('layouts.employee-layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="h5 mb-0">Edit Supplier</h3>
                    <a href="{{ route('employee.supplier.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back to List
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('employee.supplier.update', $supplier->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Supplier Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $supplier->name }}" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $supplier->email }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $supplier->phone }}" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="active" {{ (isset($supplier->status) && $supplier->status == 'active') || !isset($supplier->status) ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ isset($supplier->status) && $supplier->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group mb-4">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3">{{ $supplier->address }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3 d-flex">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-save mr-1"></i> Update Supplier
                            </button>
                            <a href="{{ route('employee.supplier.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
