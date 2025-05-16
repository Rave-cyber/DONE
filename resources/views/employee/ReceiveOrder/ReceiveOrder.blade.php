@extends('layouts.employee-layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h2 class="h5 mb-0">
                        <i class="fas fa-clipboard-check mr-2"></i>Receive Supplier Order
                    </h2>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('employee.receive-orders.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="supplier_id" class="font-weight-bold">Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="form-control border-primary" required>
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    @if((!isset($supplier->status)) || (isset($supplier->status) && $supplier->status == 'active'))
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Selected Items Table -->
                        <div class="card border-primary mb-4">
                            <div class="card-header bg-light-primary text-primary font-weight-bold">
                                <i class="fas fa-list mr-2"></i>Selected Items
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="selected-items-table">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="pl-4">Item</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                                <th class="text-right pr-4">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dynamic rows will be added here -->
                                        </tbody>
                                        <tfoot class="font-weight-bold">
                                            <tr>
                                                <td colspan="3" class="text-right">Grand Total</td>
                                                <td id="grand-total">0.00</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Add New Item Card -->
                        <div class="card border-primary mb-4">
                            <div class="card-header bg-light-primary text-primary font-weight-bold">
                                <i class="fas fa-plus-circle mr-2"></i>Add New Item
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="new_item_id">Item</label>
                                            <select id="new_item_id" class="form-control border-primary">
                                                <option value="">Select Item</option>
                                                @foreach($items as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="new_quantity">Quantity</label>
                                            <input type="number" id="new_quantity" class="form-control border-primary" value="1" min="1">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="new_price">Unit Price</label>
                                            <input type="number" id="new_price" class="form-control border-primary" step="0.01" value="0.00" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="button" id="add-item" class="btn btn-primary w-100">
                                            <i class="fas fa-plus mr-2"></i>Add Item
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden inputs will be added here by JavaScript -->
                        <div id="hidden-inputs"></div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-check-circle mr-2"></i>Submit Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const items = [];
        let itemCounter = 0;
        
        function updateGrandTotal() {
            const grandTotal = items.reduce((sum, item) => sum + (item.quantity * item.price), 0);
            document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
        }
        
        function addItemToTable(item) {
            const tableBody = document.querySelector('#selected-items-table tbody');
            const row = document.createElement('tr');
            row.dataset.id = item.id;
            
            const total = item.quantity * item.price;
            
            row.innerHTML = `
                <td class="pl-4">${item.name}</td>
                <td>${item.quantity}</td>
                <td>${item.price.toFixed(2)}</td>
                <td>${total.toFixed(2)}</td>
                <td class="text-right pr-4">
                    <button type="button" class="btn btn-danger btn-sm remove-item" data-id="${item.id}">
                        <i class="fas fa-trash-alt mr-1"></i>Remove
                    </button>
                </td>
            `;
            
            tableBody.appendChild(row);
            updateGrandTotal();
            
            row.querySelector('.remove-item').addEventListener('click', function() {
                removeItem(item.id);
            });
        }
        
        function removeItem(id) {
            const index = items.findIndex(item => item.id === id);
            if (index !== -1) {
                items.splice(index, 1);
            }
            
            document.querySelector(`#selected-items-table tbody tr[data-id="${id}"]`)?.remove();
            updateGrandTotal();
            updateHiddenInputs();
        }
        
        function updateHiddenInputs() {
            const container = document.getElementById('hidden-inputs');
            container.innerHTML = '';
            
            items.forEach((item, index) => {
                container.innerHTML += `
                    <input type="hidden" name="items[${index}][item_id]" value="${item.item_id}">
                    <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                    <input type="hidden" name="items[${index}][price]" value="${item.price}">
                `;
            });
        }
        
        document.getElementById('add-item').addEventListener('click', function() {
            const itemSelect = document.getElementById('new_item_id');
            const quantityInput = document.getElementById('new_quantity');
            const priceInput = document.getElementById('new_price');
            
            if (!itemSelect.value || !quantityInput.value || !priceInput.value) {
                alert('Please fill all fields');
                return;
            }
            
            if (parseFloat(quantityInput.value) <= 0 || parseFloat(priceInput.value) < 0) {
                alert('Quantity must be greater than 0 and price cannot be negative');
                return;
            }
            
            const newItem = {
                id: itemCounter++,
                item_id: itemSelect.value,
                name: itemSelect.options[itemSelect.selectedIndex].text,
                quantity: parseFloat(quantityInput.value),
                price: parseFloat(priceInput.value)
            };
            
            items.push(newItem);
            addItemToTable(newItem);
            updateHiddenInputs();
            
            quantityInput.value = '1';
            priceInput.value = '0.00';
            itemSelect.value = '';
        });
    });
</script>
@endsection