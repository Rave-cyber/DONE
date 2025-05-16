@extends('layouts.pdf')

@section('content')
    <h2>Sales Report: {{ $startDate }} to {{ $endDate }}</h2>
    
    <h4>Summary</h4>
    <table class="summary-table" width="100%">
        <tr>
            <th>Service</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td>Wash</td>
            <td>${{ number_format($totals['Wash'], 2) }}</td>
        </tr>
        <tr>
            <td>Fold</td>
            <td>${{ number_format($totals['Fold'], 2) }}</td>
        </tr>
        <tr>
            <td>Ironing</td>
            <td>${{ number_format($totals['Ironing'], 2) }}</td>
        </tr>
        <tr>
            <td><strong>Total</strong></td>
            <td><strong>${{ number_format($totals['All'], 2) }}</strong></td>
        </tr>
    </table>

    <h4>Order Details</h4>
    <table class="order-table" width="100%" cellpadding="5">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Services</th>
                <th>Status</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->order_name }}</td>
                <td>{{ $order->date }}</td>
                <td>{{ implode(', ', (array)$order->service_type) }}</td>
                <td>{{ $order->status }}</td>
                <td>${{ number_format($order->amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection