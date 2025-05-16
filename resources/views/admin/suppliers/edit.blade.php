@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="h5 mb-0">Edit Supplier</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Supplier Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $supplier->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $supplier->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $supplier->phone }}" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address">{{ $supplier->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="active" {{ (old('status', $supplier->status ?? 'active') == 'active' ? 'selected' : '') }}>
                                    Active
                                </option>
                                <option value="inactive" {{ (old('status', $supplier->status ?? 'active') == 'inactive' ? 'selected' : '') }}>
                                    Inactive
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.suppliers.index') }}" class="text-gray-600 hover:underline">
                            Cancel
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
