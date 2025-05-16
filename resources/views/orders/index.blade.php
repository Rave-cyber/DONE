@extends('layouts.employee-layout')

@section('title', 'Order Management')

@section('content')
<div class="container-fluid">
    <div class="page-title">Order Management</div>
    
    <!-- Search Box -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" id="searchInput" class="form-control" placeholder="Search by Order ID or Customer Name..." 
                       value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="performSearch()">
                        <i class="fas fa-search"></i> Search
                    </button>
                    @if(request('search'))
                    <button class="btn btn-secondary" type="button" onclick="clearSearch()">
                        <i class="fas fa-times"></i> Clear
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Order Cards -->
    <div class="order-cards-container">
        @foreach ($activeOrders as $order)
        <div class="order-card">
            <div class="order-card-header">
                <span class="order-id">Order #{{ $order->id }}</span>
                <span class="order-date">{{ $order->date }}</span>
            </div>
            
            <div class="order-customer">{{ $order->order_name }}</div>
            
            <div class="order-details">
                <div class="detail-row">
                    <div class="detail-label">Service Type:</div>
                    <div class="detail-value">
                    @if(is_array($order->service_type))
                        {{ implode(', ', $order->service_type) }}
                    @else
                        {{ $order->service_type }}
                    @endif
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Weight:</div>
                    <div class="detail-value">{{ $order->weight }} kg</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Payment Method:</div>
                    <div class="detail-value">{{ $order->payment_method }}</div>
                </div>
            </div>
            
            <div class="order-amount">₱{{ number_format($order->amount, 2) }}</div>
            
            <div class="status-payment-container">
                <div class="status-container">
                    <div class="status-label">Status:</div>
                    <div class="order-status status-{{ strtolower(str_replace(' ', '-', $order->status)) }}">
                        {{ $order->status }}
                    </div>
                </div>
                <div class="payment-container">
                    <div class="payment-label">Payment:</div>
                    <div class="payment-status payment-{{ $order->payment_status ?? 'pending' }}">
                        {{ $order->payment_status ?? 'Pending' }}
                    </div>
                </div>
            </div>
            
            <select class="status-select" data-order-id="{{ $order->id }}" data-current-status="{{ $order->status }}" onchange="validateAndUpdateOrderStatus(this)">
                @php
                    $statuses = ['Pending', 'Washing', 'Drying', 'Ironing', 'Ready', 'Completed'];
                    $currentStatusIndex = array_search($order->status, $statuses);
                    // Only show current status and next status (if available)
                    foreach($statuses as $index => $status) {
                        $disabled = ($index != $currentStatusIndex && $index != $currentStatusIndex + 1);
                        if ($index <= $currentStatusIndex + 1) {
                            echo '<option value="'.$status.'" '.($order->status == $status ? 'selected' : '').' '.($disabled ? 'disabled' : '').'>'.$status.($status == 'Ready' ? ' for Pickup' : '').'</option>';
                        }
                    }
                @endphp
            </select>
            
            <div class="order-actions">
                <button class="btn-action btn-view" onclick="viewOrderDetails({{ $order->id }})">
                    <i class="fas fa-eye"></i> View
                </button>
                <a href="{{ route('orders.assign.form', $order->id) }}" class="btn-action btn-update">
                    <i class="fas fa-user-plus"></i> Assign
                </a>
                @if($order->status == 'Completed' && ($order->payment_status ?? 'pending') == 'paid')
                    <button class="btn-action btn-archive" onclick="archiveOrder({{ $order->id }})">
                        <i class="fas fa-archive"></i> Archive
                    </button>
                @else
                    <button class="btn-action btn-mark-paid" onclick="markAsPaid({{ $order->id }})" 
                        {{ ($order->payment_status ?? 'pending') == 'paid' ? 'disabled' : '' }}>
                        <i class="fas fa-check-circle"></i> Mark Paid
                    </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($activeOrders->hasPages())
    <div class="pagination-container">
        <div class="pagination-info">
            Showing {{ $activeOrders->firstItem() }} to {{ $activeOrders->lastItem() }} of {{ $activeOrders->total() }} results
        </div>
        <div class="pagination-controls">
            @if ($activeOrders->onFirstPage())
                <span class="page-link disabled">&laquo;</span>
            @else
                <a href="{{ $activeOrders->previousPageUrl() }}" class="page-link">&laquo;</a>
            @endif

            @foreach ($activeOrders->getUrlRange(1, $activeOrders->lastPage()) as $page => $url)
                @if ($page == $activeOrders->currentPage())
                    <span class="page-link active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                @endif
            @endforeach

            @if ($activeOrders->hasMorePages())
                <a href="{{ $activeOrders->nextPageUrl() }}" class="page-link">&raquo;</a>
            @else
                <span class="page-link disabled">&raquo;</span>
            @endif
        </div>
    </div>
    @endif

    <!-- Archived Orders Section -->
    <div class="mt-5">
        <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#archivedOrders">
            <i class="fas fa-archive"></i> Show Archived Orders ({{ $archivedOrders->count() }})
        </button>
        <div class="collapse mt-3" id="archivedOrders">
            <div class="order-cards-container">
                @foreach ($archivedOrders as $order)
                <div class="order-card archived">
                    <div class="order-card-header">
                        <span class="order-id">Order #{{ $order->id }}</span>
                        <span class="order-date">{{ $order->date }}</span>
                    </div>
                    
                    <div class="order-customer">{{ $order->order_name }}</div>
                    
                    <div class="order-details">
                        <div class="detail-row">
                            <div class="detail-label">Service Type:</div>
                            <div class="detail-value">
                                @if(is_array($order->service_type))
                                    {{ implode(', ', $order->service_type) }}
                                @else
                                    {{ $order->service_type }}
                                @endif
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Amount:</div>
                            <div class="detail-value">₱{{ number_format($order->amount, 2) }}</div>
                        </div>
                    </div>
                    
                    <div class="status-payment-container">
                        <div class="status-container">
                            <div class="status-label">Status:</div>
                            <div class="order-status status-completed">
                                {{ $order->status }}
                            </div>
                        </div>
                        <div class="payment-container">
                            <div class="payment-label">Payment:</div>
                            <div class="payment-status payment-paid">
                                Paid
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-actions">
                        <button class="btn-action btn-view" onclick="viewOrderDetails({{ $order->id }})">
                            <i class="fas fa-eye"></i> View
                        </button>
                        <button class="btn-action btn-archive" onclick="unarchiveOrder({{ $order->id }})">
                            <i class="fas fa-undo"></i> Restore
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details - #<span id="modalOrderId"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="orderDetailsContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printReceipt()">
                    <i class="fas fa-print"></i> Print Receipt
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --primary-color: #079CD6;
        --secondary-color: #2F356D;
        --accent-color: #17E8FF;
        --light-bg: rgba(255, 255, 255, 0.9);
    }
    
    .main-content {
        overflow-y: auto;
        height: calc(100vh - 40px); /* Adjust padding/margins as needed */
        padding: 20px;
    }
    
    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 10px;
    }
    
    .page-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--primary-color);
        border-radius: 2px;
    }
    
    .order-cards-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    
    .order-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        min-height: 420px; /* Consistent card height */
        position: relative;
    }
    
    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    
    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
        width: 100%;
    }
    
    .order-id {
        font-weight: 700;
        color: var(--secondary-color);
    }
    
    .order-date {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .order-customer {
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--secondary-color);
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .order-details {
        margin-bottom: 15px;
        width: 100%;
        flex-grow: 1;
    }
    
    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        width: 100%;
    }
    
    .detail-label {
        color: #6c757d;
        width: 45%;
        font-size: 0.9rem;
    }
    
    .detail-value {
        font-weight: 500;
        width: 55%;
        text-align: right;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.9rem;
    }
    
    .order-amount {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 10px 0;
        width: 100%;
        text-align: right;
    }
    
    .status-payment-container {
        display: flex;
        justify-content: space-between;
        width: 100%;
        margin-bottom: 12px;
    }
    
    .status-container, .payment-container {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    
    .status-label, .payment-label {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 4px;
    }
    
    .order-status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: bold;
        text-transform: capitalize;
        font-size: 0.85rem;
        min-width: 90px;
        text-align: center;
    }
    
    .status-pending {
        background-color: #FFD700;
        color: #000;
    }
    
    .status-washing {
        background-color: #1E90FF;
        color: #FFF;
    }
    
    .status-drying {
        background-color: #9370DB;
        color: #FFF;
    }
    
    .status-ironing {
        background-color: #FF8C00;
        color: #FFF;
    }
    
    .status-ready {
        background-color: #32CD32;
        color: #FFF;
    }
    
    .status-completed {
        background-color: #228B22;
        color: #FFF;
    }
    
    .payment-status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.85rem;
        min-width: 80px;
        text-align: center;
    }
    
    .payment-pending {
        background-color: #FF6347;
        color: #FFF;
    }
    
    .payment-paid {
        background-color: #20B2AA;
        color: #FFF;
    }
    
    .status-select {
        width: 100%;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #ddd;
        margin: 0 0 12px 0;
        background-color: #f8f9fa;
        font-size: 0.9rem;
        height: 38px;
    }
    
    .order-actions {
        display: flex;
        justify-content: space-between;
        width: 100%;
        margin-top: auto;
    }
    
    .btn-action {
        border-radius: 8px;
        padding: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        flex: 1;
        margin: 0 4px;
        text-align: center;
        font-size: 0.9rem;
        white-space: nowrap;
    }
    
    .btn-action:first-child {
        margin-left: 0;
    }
    
    .btn-action:last-child {
        margin-right: 0;
    }
    
    .btn-view {
        background: var(--secondary-color);
        color: white;
    }
    
    .btn-view:hover {
        background: #1e2258;
    }
    
    .btn-update {
        background: var(--primary-color);
        color: white;
    }
    
    .btn-update:hover {
        background: #057baa;
    }
    
    .btn-mark-paid {
        background: #28a745;
        color: white;
    }
    
    .btn-mark-paid:hover {
        background: #218838;
    }

    .btn-archive {
        background: #6c757d;
        color: white;
    }

    .btn-archive:hover {
        background: #5a6268;
    }
    
    .pagination-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 20px 0;
        font-size: 14px;
    }

    .pagination-info {
        margin-bottom: 8px;
        color: #666;
    }

    .pagination-controls {
        display: flex;
        gap: 5px;
    }

    .page-link {
        padding: 5px 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #079CD6;
        transition: all 0.2s;
    }

    .page-link:hover:not(.disabled):not(.active) {
        background-color: #f5f5f5;
    }

    .page-link.active {
        background-color: #079CD6;
        color: white;
        border-color: #079CD6;
    }

    .page-link.disabled {
        color: #999;
        cursor: not-allowed;
    }
    
    #searchInput {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 10px 15px;
    }
    
    .input-group-append .btn {
        border-radius: 0 8px 8px 0;
    }
    
    /* Archived cards special styling */
    .order-card.archived {
        min-height: 350px; /* Slightly smaller for archived cards */
        background-color: #f8f9fa;
    }
    
    /* Sidebar Styles for Mobile */
    @media (max-width: 768px) {
        .order-cards-container {
            grid-template-columns: 1fr;
        }
        
        .order-card {
            min-height: auto; /* Allow cards to size naturally on mobile */
        }
        
        .sidebar {
            width: 100%;
            height: auto;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            padding: 15px;
        }
        
        .sidebar img {
            margin-bottom: 15px;
            max-width: 120px;
        }
        
        .sidebar .nav-link {
            margin: 5px 10px;
            padding: 6px 12px;
        }
        
        .sidebar .log-out {
            margin-top: 0;
            margin-left: auto;
        }
        
        .btn-action {
            padding: 6px;
            font-size: 0.8rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function viewOrderDetails(orderId) {
        $.ajax({
            url: '/orders/' + orderId,
            method: 'GET',
            success: function(data) {
                $('#modalOrderId').text(data.id);
                const statusLogs = Array.isArray(data.status_logs) ? data.status_logs : [];
                const formattedDate = data.date ? new Date(data.date).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }) : 'N/A';
                const employees = Array.isArray(data.employees) && data.employees.length > 0
                    ? data.employees.map(emp => `${emp.first_name} ${emp.last_name} (${emp.position || 'N/A'})`).join(', ')
                    : 'None';
                    
                $('#orderDetailsContent').html(`
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Customer Name:</strong> ${data.order_name || 'N/A'}</p>
                            <p><strong>Order Date:</strong> ${formattedDate}</p>
                            <p><strong>Weight:</strong> ${data.weight ? data.weight + ' kg' : 'N/A'}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong> 
                                <span class="order-status status-${data.status ? data.status.toLowerCase().replace(' ', '-') : 'unknown'}">
                                    ${data.status || 'Unknown'}
                                </span>
                            </p>
                            <p><strong>Payment:</strong> 
                                <span class="payment-status payment-${data.payment_status || 'pending'}">
                                    ${data.payment_status || 'Pending'}
                                </span>
                            </p>
                            <p><strong>Amount:</strong> ₱${data.amount ? parseFloat(data.amount).toFixed(2) : '0.00'}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p><strong>Service Type:</strong> ${data.service_type && Array.isArray(data.service_type) && data.service_type.length > 0 ? data.service_type.join(', ') : 'N/A'}</p>
                            <p><strong>Payment Method:</strong> ${data.payment_method || 'N/A'}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Special Instructions:</strong> ${data.special_instructions || 'None'}</p>
                            <p><strong>Assigned Employees:</strong> ${employees}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Status History</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Changed At</th>
                                        <th>Changed By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${statusLogs.length > 0 ? statusLogs.map(log => `
                                        <tr>
                                            <td>${log.status || 'N/A'}</td>
                                            <td>${log.changed_at ? new Date(log.changed_at).toLocaleString() : 'N/A'}</td>
                                            <td>${log.user && log.user.name ? log.user.name : 'N/A'}</td>
                                        </tr>
                                    `).join('') : `
                                        <tr>
                                            <td colspan="3">No status history available</td>
                                        </tr>
                                    `}
                                </tbody>
                            </table>
                        </div>
                    </div>
                `);
                $('#orderDetailsModal').modal('show');
            },
            error: function(xhr) {
                console.error('Error fetching order details:', xhr.responseJSON);
                let errorMessage = xhr.responseJSON?.error || xhr.responseJSON?.message || 'Failed to load order details.';
                alert('Error: ' + errorMessage);
            }
        });
    }

    function validateAndUpdateOrderStatus(selectElement) {
        const orderId = selectElement.dataset.orderId;
        const currentStatus = selectElement.dataset.currentStatus;
        const newStatus = selectElement.value;
        
        // Define the valid status workflow
        const statusWorkflow = ['Pending', 'Washing', 'Drying', 'Ironing', 'Ready', 'Completed'];
        
        const currentIndex = statusWorkflow.indexOf(currentStatus);
        const newIndex = statusWorkflow.indexOf(newStatus);
        
        // Only allow moving to the next status
        if (newIndex !== currentIndex && newIndex !== currentIndex + 1) {
            alert('Invalid status change. You can only advance to the next status in the workflow.');
            // Reset select to current status
            selectElement.value = currentStatus;
            return;
        }
        
        // If trying to move backwards
        if (newIndex < currentIndex) {
            alert('Cannot move backward in the workflow. Status changes must follow the sequence.');
            // Reset select to current status
            selectElement.value = currentStatus;
            return;
        }
        
        // If it's a valid status change, proceed with the update
        if (newIndex !== currentIndex) {
            updateOrderStatus(selectElement);
        }
    }

    function updateOrderStatus(selectElement) {
        const orderId = selectElement.dataset.orderId;
        const newStatus = selectElement.value;
        
        $.ajax({
            url: '/orders/' + orderId + '/status',
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                status: newStatus
            },
            success: function(response) {
                const card = selectElement.closest('.order-card');
                const badge = card.querySelector('.order-status');
                
                badge.className = 'order-status';
                badge.classList.add('status-' + newStatus.toLowerCase().replace(' ', '-'));
                badge.textContent = newStatus;
                
                // Update the data attribute to reflect the new current status
                selectElement.dataset.currentStatus = newStatus;
                
                // Update available options after status change
                updateStatusOptions(selectElement, newStatus);
                
                alert(response.success);
                
                if (newStatus === 'Completed') {
                    location.reload();
                }
            },
            error: function(xhr) {
                console.error('Error response:', xhr.responseJSON);
                let errorMessage = 'An error occurred while updating the status.';
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    } else if (xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join(', ');
                    }
                }
                alert('Error updating status: ' + errorMessage);
                
                // Reset the select to the current status on error
                selectElement.value = selectElement.dataset.currentStatus;
            }
        });
    }
    
    function updateStatusOptions(selectElement, currentStatus) {
        const statusWorkflow = ['Pending', 'Washing', 'Drying', 'Ironing', 'Ready', 'Completed'];
        const currentIndex = statusWorkflow.indexOf(currentStatus);
        
        // Clear existing options
        selectElement.innerHTML = '';
        
        // Add current status
        const currentOption = document.createElement('option');
        currentOption.value = currentStatus;
        currentOption.text = currentStatus === 'Ready' ? 'Ready for Pickup' : currentStatus;
        currentOption.selected = true;
        selectElement.appendChild(currentOption);
        
        // Add next status if available
        if (currentIndex < statusWorkflow.length - 1) {
            const nextStatus = statusWorkflow[currentIndex + 1];
            const nextOption = document.createElement('option');
            nextOption.value = nextStatus;
            nextOption.text = nextStatus === 'Ready' ? 'Ready for Pickup' : nextStatus;
            selectElement.appendChild(nextOption);
        }
    }

    function markAsPaid(orderId) {
        if (!confirm('Mark this order as paid? This will also archive the order if it is completed.')) return;
        
        $.ajax({
            url: '/orders/' + orderId + '/mark-paid',
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                console.error('Error response:', xhr.responseJSON);
                let errorMessage = xhr.responseJSON?.error || xhr.responseJSON?.message || 'An error occurred.';
                alert('Error: ' + errorMessage);
            }
        });
    }

    function archiveOrder(orderId) {
        if (!confirm('Archive this order?')) return;
        
        $.ajax({
            url: '/orders/' + orderId + '/archive',
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                console.error('Error response:', xhr.responseJSON);
                let errorMessage = xhr.responseJSON?.error || xhr.responseJSON?.message || 'An error occurred.';
                alert('Error: ' + errorMessage);
            }
        });
    }

    function unarchiveOrder(orderId) {
        if (!confirm('Restore this order from archive?')) return;
        
        $.ajax({
            url: '/orders/' + orderId + '/unarchive',
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                console.error('Error response:', xhr.responseJSON);
                let errorMessage = xhr.responseJSON?.error || xhr.responseJSON?.message || 'An error occurred.';
                alert('Error: ' + errorMessage);
            }
        });
    }

    function printReceipt() {
        alert('Receipt printing functionality would be implemented here');
    }
    
    function performSearch() {
        const searchTerm = document.getElementById('searchInput').value.trim();
        const url = new URL(window.location.href);
        
        if (searchTerm) {
            url.searchParams.set('search', searchTerm);
        } else {
            url.searchParams.delete('search');
        }
        
        // Reset to first page when searching
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }
    
    function clearSearch() {
        const url = new URL(window.location.href);
        url.searchParams.delete('search');
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }
    
    // Handle Enter key in search input
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
</script>
@endpush