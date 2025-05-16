@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="h3 mb-0 text-gray-800">Sales Report</h1>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Generate Report</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.sales_report.generate') }}" method="POST">
                @csrf
                
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="{{ $startDate }}" required>
                    </div>
                    
                    <div class="form-group col-md-5">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="{{ $endDate }}" required>
                    </div>
                    
                    <div class="form-group col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-chart-bar fa-sm"></i> Generate
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection