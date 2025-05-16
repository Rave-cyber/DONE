@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Sales Report: {{ $startDate->format('m/d/Y') }} to {{ $endDate->format('m/d/Y') }}</h1>
    <h3>Total Sales: ₱{{ number_format($totalSales, 2) }}</h3>
    
    <div class="mt-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->created_at->format('m/d/Y H:i') }}</td>
                    <td>{{ $transaction->customer->name ?? 'Guest' }}</td>
                    <td>₱{{ number_format($transaction->total_amount, 2) }}</td>
                    <td>{{ ucfirst($transaction->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('admin.sales_report.index') }}" class="btn btn-secondary">
            Back to Report Generator
        </a>
        
        <button onclick="window.print()" class="btn btn-primary ml-2">
            Print Report
        </button>
    </div>
</div>
@endsection