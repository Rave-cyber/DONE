@extends('layouts.employee-layout')

@section('title', 'Transactions')

@section('content')
<style>
    :root {
      --primary-color: #079CD6;
      --secondary-color: #2F356D;
      --accent-color: #17E8FF;
      --light-bg: rgba(255, 255, 255, 0.9);
    }
    
    .order-and-transaction {
      font-size: 28px;
      font-weight: 700;
      color: var(--secondary-color);
      margin-bottom: 25px;
      position: relative;
      padding-bottom: 10px;
    }
    
    .order-and-transaction::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 60px;
      height: 4px;
      background: var(--primary-color);
      border-radius: 2px;
    }
    
    .form-container {
      background: white;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      margin-bottom: 30px;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-group label {
      font-weight: 600;
      color: var(--secondary-color);
      margin-bottom: 8px;
      display: block;
    }
    
    .form-control {
      border-radius: 8px;
      border: 1px solid #d9d9d9;
      padding: 10px 15px;
      font-size: 15px;
      transition: all 0.3s ease;
      background-color: white;
    }
    
    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(7, 156, 214, 0.25);
    }
    
    .input-group-text {
      background-color: #f8f9fa;
      border: 1px solid #d9d9d9;
      border-radius: 8px;
      font-size: 15px;
      color: var(--secondary-color);
    }
    
    .btn-submit {
      background-color: var(--primary-color);
      border: none;
      border-radius: 8px;
      padding: 12px 25px;
      font-size: 16px;
      font-weight: 600;
      color: white;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    
    .btn-submit:hover {
      background-color: #057baa;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .service-card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      margin-top: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      border: 1px solid #e9ecef;
    }
    
    .service-card-title {
      font-size: 18px;
      font-weight: 600;
      color: var(--secondary-color);
      margin-bottom: 15px;
      display: flex;
      align-items: center;
    }
    
    .service-card-title i {
      margin-right: 10px;
      color: var(--primary-color);
    }
    
    .service-options {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 15px;
    }
    
    .service-option {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 15px;
      border-radius: 8px;
      background: #f8f9fa;
      transition: all 0.3s ease;
      cursor: pointer;
      border: 2px solid transparent;
    }
    
    .service-option:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      border-color: var(--primary-color);
    }
    
    .service-option.selected {
      background: rgba(7, 156, 214, 0.1);
      border-color: var(--primary-color);
    }
    
    .service-icon {
      font-size: 24px;
      margin-bottom: 10px;
      color: var(--primary-color);
    }
    
    .service-name {
      font-weight: 600;
      margin-bottom: 5px;
      color: var(--secondary-color);
    }
    
    .service-price {
      font-size: 14px;
      color: #6c757d;
    }
    
    .payment-method-card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      margin-top: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      border: 1px solid #e9ecef;
    }
    
    .payment-options {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }
    
    .payment-option {
      flex: 1;
      min-width: 120px;
      padding: 12px;
      border-radius: 8px;
      background: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      cursor: pointer;
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }
    
    .payment-option.selected {
      background: rgba(7, 156, 214, 0.1);
      border-color: var(--primary-color);
    }
    
    .payment-option i {
      font-size: 20px;
    }
    
    .payment-option .fa-credit-card { color: #28a745; }
    .payment-option .fa-money-bill-wave { color: #17a2b8; }
    .payment-option .fa-mobile-alt { color: #6f42c1; }
    
    .special-instructions {
      margin-top: 20px;
    }
    
    .special-instructions textarea {
      width: 100%;
      min-height: 100px;
      resize: vertical;
      border-radius: 8px;
      padding: 15px;
      border: 1px solid #d9d9d9;
      transition: all 0.3s ease;
    }
    
    .special-instructions textarea:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(7, 156, 214, 0.25);
    }
    
    .amount-display {
      background: white;
      border-radius: 12px;
      padding: 20px;
      margin-top: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      border: 1px solid #e9ecef;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .amount-label {
      font-weight: 600;
      color: var(--secondary-color);
      font-size: 18px;
    }
    
    .amount-value {
      font-size: 24px;
      font-weight: 700;
      color: var(--primary-color);
    }
    
    .modal-header {
      border-bottom: none;
      padding-bottom: 0;
    }
    
    .modal-title {
      color: var(--secondary-color);
      font-weight: 700;
    }
    
    .modal-body {
      padding-top: 0;
    }
    
    .detail-item {
      margin-bottom: 12px;
      display: flex;
    }
    
    .detail-label {
      font-weight: 600;
      color: var(--secondary-color);
      min-width: 150px;
    }
    
    .detail-value {
      color: #495057;
    }
    
    .modal-footer {
      border-top: none;
      padding-top: 0;
    }
    
    @media (max-width: 768px) {
      .service-options {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
<div class="container-fluid py-4">
    <div class="order-and-transaction">Create New Transaction</div>
    
    @if($errors->any())
    <div class="alert alert-danger">
        <h5>Please fix these errors:</h5>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

        <form action="{{ route('orders.store') }}" method="POST" class="form-container" id="orderForm">
            @csrf
            
            <div class="form-group">
                <label for="orderName">Customer Name</label>
                <input type="text" class="form-control @error('order_name') is-invalid @enderror" 
                       id="orderName" name="order_name" placeholder="Enter customer name" 
                       value="{{ old('order_name') }}" required>
                @error('order_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" class="form-control @error('contact') is-invalid @enderror" 
                       id="contact" name="contact" placeholder="Enter customer contact number" 
                       value="{{ old('contact') }}" required>
                @error('contact')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="weight">Laundry Weight</label>
                <div class="input-group">
                    <input type="number" class="form-control @error('weight') is-invalid @enderror" 
                           id="weight" name="weight" placeholder="Enter weight" 
                           required step="0.01" min="0.1" value="{{ old('weight', 1) }}"
                           oninput="calculateAmount()">
                    <div class="input-group-append">
                        <span class="input-group-text">kg</span>
                    </div>
                    @error('weight')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <small class="form-text text-muted">Prices increase for weights over base limits</small>
            </div>
            
            <div class="form-group">
                <label for="date">Order Date</label>
                <input type="date" class="form-control @error('date') is-invalid @enderror" 
                       id="date" name="date" required value="{{ old('date', date('Y-m-d')) }}">
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="service-card">
                <div class="service-card-title">
                    <i class="fas fa-concierge-bell"></i> Service Type
                </div>
                <div class="service-options">
                    <div class="service-option selected" onclick="toggleService(this, 'Wash')" data-service="Wash">
                        <i class="fas fa-tshirt service-icon"></i>
                        <div class="service-name">Wash</div>
                        <div class="service-price" id="wash-price">
                            ₱{{ number_format($prices['Wash']->base_price ?? 50, 2) }}/kg (base)
                        </div>
                        <input type="checkbox" id="Wash" name="service_type[]" value="Wash" checked hidden>
                    </div>
                    
                    <div class="service-option" onclick="toggleService(this, 'Fold')" data-service="Fold">
                        <i class="fas fa-people-arrows service-icon"></i>
                        <div class="service-name">Fold</div>
                        <div class="service-price" id="fold-price">
                            ₱{{ number_format($prices['Fold']->base_price ?? 30, 2) }}/kg (base)
                        </div>
                        <input type="checkbox" id="Fold" name="service_type[]" value="Fold" hidden>
                    </div>
                    
                    <div class="service-option" onclick="toggleService(this, 'Ironing')" data-service="Ironing">
                        <i class="fas fa-hand-sparkles service-icon"></i>
                        <div class="service-name">Ironing</div>
                        <div class="service-price" id="ironing-price">
                            ₱{{ number_format($prices['Ironing']->base_price ?? 40, 2) }}/kg (base)
                        </div>
                        <input type="checkbox" id="Ironing" name="service_type[]" value="Ironing" hidden>
                    </div>
                </div>
            </div>
            
            <!-- Hidden field for payment method, defaulting to Cash -->
            <input type="hidden" name="payment_method" value="Cash">
            
            <div class="amount-display">
                <div class="amount-label">Total Amount:</div>
                <div class="amount-value">₱<span id="amount">0.00</span></div>
                <input type="hidden" id="amountInput" name="amount" value="0">
            </div>
            
            <div class="form-group special-instructions">
                <label for="specialInstructions">Special Instructions</label>
                <textarea class="form-control" id="specialInstructions" name="special_instructions" 
                          placeholder="Any special instructions for your order...">{{ old('special_instructions') }}</textarea>
            </div>
            
            <div class="form-group">
                <button type="button" class="btn btn-submit" onclick="showConfirmation()">Create Transaction</button>
            </div>
        </form>
    </div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Transaction Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 class="mb-3"><i class="fas fa-info-circle text-primary mr-2"></i>Please review your transaction details:</h6>
                
                <div class="detail-item">
                    <div class="detail-label">Customer Name:</div>
                    <div class="detail-value" id="orderNameDisplay"></div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Contact Number:</div>
                    <div class="detail-value" id="contactDisplay"></div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Weight:</div>
                    <div class="detail-value" id="weightDisplay"></div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Services:</div>
                    <div class="detail-value" id="serviceTypeDisplay"></div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Special Instructions:</div>
                    <div class="detail-value" id="specialInstructionsDisplay">None</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">Total Amount:</div>
                    <div class="detail-value font-weight-bold text-primary">₱<span id="amountDisplay"></span></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Edit Transaction</button>
                <button type="button" class="btn btn-primary" id="confirmTransactionBtn">
                    <i class="fas fa-check mr-2"></i>Confirm Transaction
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    const servicePrices = {
        Wash: {
            base_price: {{ $prices['Wash']->base_price ?? 50 }},
        },
        Fold: {
            base_price: {{ $prices['Fold']->base_price ?? 30 }},
        },
        Ironing: {
            base_price: {{ $prices['Ironing']->base_price ?? 40 }},
        }
    };

    function calculateAmount() {
        const weight = parseFloat(document.getElementById('weight').value) || 0;
        let total = 0;
        let serviceDetails = [];

        document.querySelectorAll('input[name="service_type[]"]:checked').forEach(checkbox => {
            const service = checkbox.value;
            const serviceCost = calculateServiceCost(service, weight);
            total += serviceCost;
            serviceDetails.push(`${service}: ₱${serviceCost.toFixed(2)}`);
        });

        const formattedTotal = total.toFixed(2);
        document.getElementById('amount').textContent = formattedTotal;
        document.getElementById('amountInput').value = formattedTotal;
        document.getElementById('amountDisplay').textContent = formattedTotal;
        document.getElementById('serviceTypeDisplay').textContent = serviceDetails.join(', ') || 'None';
    }

    function calculateServiceCost(service, weight) {
            const serviceData = servicePrices[service];
            return weight * serviceData.base_price;
        }

    function toggleService(element, service) {
        const checkbox = document.getElementById(service);
        checkbox.checked = !checkbox.checked;
        element.classList.toggle('selected');
        calculateAmount();
    }

    function selectPayment(element, method) {
        document.querySelectorAll('.payment-option').forEach(opt => {
            opt.classList.remove('selected');
        });
        element.classList.add('selected');
        document.querySelector(`input[value="${method}"]`).checked = true;
    }

    function generateReceipt() {
        const orderName = document.getElementById('orderName').value;
        const contact = document.getElementById('contact').value;
        const weight = document.getElementById('weight').value;
        const services = Array.from(document.querySelectorAll('input[name="service_type[]"]:checked'))
                            .map(el => el.value).join(', ');
        const amount = document.getElementById('amount').textContent;
        const instructions = document.getElementById('specialInstructions').value || 'None';
        const date = new Date().toLocaleString();
        
        // Calculate VAT (12%)
        const amountValue = parseFloat(amount);
        const vatAmount = amountValue * 0.12;
        const subtotal = amountValue - vatAmount;
        
        // Generate tracking ID (date-based)
        const trackingId = 'TRK-' + Date.now().toString().substring(6);

        return `================================\n` +
               `        LAUNDRY SERVICE         \n` +
               `================================\n` +
               `Order ID: ${trackingId}\n` +
               `Date: ${date}\n` +
               `Customer: ${orderName}\n` +
               `Contact: ${contact}\n` +
               `================================\n` +
               `Weight: ${weight} kg\n` +
               `Services: ${services}\n` +
               `Special Instructions: ${instructions}\n` +
               `================================\n` +
               `Subtotal: ₱${subtotal.toFixed(2)}\n` +
               `VAT (12%): ₱${vatAmount.toFixed(2)}\n` +
               `Total Amount: ₱${amount}\n` +
               `================================\n` +
               `  For order tracking, visit:\n` +
               `  https://laundrysite.com/track\n` +
               `  and enter your Order ID\n` +
               `================================\n` +
               `Thank you for your business!\n` +
               `================================`;
    }

    function downloadReceipt(content) {
        const blob = new Blob([content], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `receipt_${new Date().toISOString().slice(0,10)}.txt`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    function showConfirmation() {
        const checkedServices = document.querySelectorAll('input[name="service_type[]"]:checked');
        
        if (checkedServices.length === 0) {
            alert('Please select at least one service');
            return;
        }
        
        if (!document.getElementById('orderForm').checkValidity()) {
            document.getElementById('orderForm').reportValidity();
            return;
        }
        
        // Update modal display
        document.getElementById('orderNameDisplay').textContent = document.getElementById('orderName').value;
        document.getElementById('contactDisplay').textContent = document.getElementById('contact').value;
        document.getElementById('weightDisplay').textContent = document.getElementById('weight').value + ' kg';
        document.getElementById('serviceTypeDisplay').textContent = 
            Array.from(document.querySelectorAll('input[name="service_type[]"]:checked'))
                .map(el => el.value).join(', ') || 'None';
        
        const specialInstructions = document.getElementById('specialInstructions').value;
        document.getElementById('specialInstructionsDisplay').textContent = specialInstructions || 'None';
        
        $('#confirmationModal').modal('show');
    }

    document.addEventListener('DOMContentLoaded', function() {
        calculateAmount();
        
        document.getElementById('confirmTransactionBtn').addEventListener('click', function() {
            // Generate and download receipt
            const receiptContent = generateReceipt();
            downloadReceipt(receiptContent);
            
            // Submit the form
            $('#confirmationModal').modal('hide');
            setTimeout(() => {
                document.getElementById('orderForm').submit();
            }, 500);
        });
    });
</script>
@endsection