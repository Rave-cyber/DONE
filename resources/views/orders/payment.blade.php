@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Process Payment for Order #{{ $order->id }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('orders.payment.process', $order) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="order_amount" class="col-md-4 col-form-label text-md-right">Order Amount</label>
                            <div class="col-md-6">
                                <input id="order_amount" type="text" class="form-control" 
                                    value="₱{{ number_format($order->amount, 2) }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="payment_method" class="col-md-4 col-form-label text-md-right">Payment Method</label>
                            <div class="col-md-6">
                                <select id="payment_method" class="form-control @error('payment_method') is-invalid @enderror" 
                                    name="payment_method" required>
                                    <option value="">Select Payment Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="GCash">GCash</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                </select>
                                @error('payment_method')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount_received" class="col-md-4 col-form-label text-md-right">Amount Received</label>
                            <div class="col-md-6">
                                <input id="amount_received" type="number" step="0.01" 
                                    class="form-control @error('amount_received') is-invalid @enderror" 
                                    name="amount_received" required autofocus>
                                @error('amount_received')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="change" class="col-md-4 col-form-label text-md-right">Change</label>
                            <div class="col-md-6">
                                <input id="change" type="text" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Process Payment
                                </button>
                                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountReceived = document.getElementById('amount_received');
    const orderAmount = {{ $order->amount }};
    const changeField = document.getElementById('change');

    amountReceived.addEventListener('input', function() {
        const received = parseFloat(this.value) || 0;
        const change = received - orderAmount;
        
        if (change >= 0) {
            changeField.value = '₱' + change.toFixed(2);
        } else {
            changeField.value = 'Insufficient amount';
        }
    });
});
</script>
@endsection