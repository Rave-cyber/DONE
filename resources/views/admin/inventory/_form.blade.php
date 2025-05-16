
                <div class="form-group mb-3">
                    <label for="item-name" class="form-label">Item Name</label>
                    <input type="text" class="form-control" id="item-name" name="name" 
                           value="{{ old('name', $inventoryItem->name ?? '') }}" required>
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="item-category" class="form-label">Category</label>
                    <select class="form-select" id="item-category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="Cleaning Supplies" {{ (old('category', $inventoryItem->category ?? '') == 'Cleaning Supplies' ? 'selected' : '') }}>
                            Cleaning Supplies
                        </option>
                        <option value="Equipment" {{ (old('category', $inventoryItem->category ?? '') == 'Equipment' ? 'selected' : '') }}>
                            Equipment
                        </option>
                        <option value="Packaging" {{ (old('category', $inventoryItem->category ?? '') == 'Packaging' ? 'selected' : '') }}>
                            Packaging
                        </option>
                        <option value="Other" {{ (old('category', $inventoryItem->category ?? '') == 'Other' ? 'selected' : '') }}>
                            Other
                        </option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="item-quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control bg-light" id="item-quantity" name="quantity" 
           min="0" value="{{ old('quantity', $inventoryItem->quantity ?? 0) }}" readonly>
                            <small class="text-muted">Quantity cannot be edited directly</small>
                            @error('quantity')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="item-price" class="form-label">Price (₱)</label>
                            <input type="number" class="form-control" id="item-price" name="price" 
                                   min="0" step="0.01" value="{{ old('price', $inventoryItem->price ?? 0) }}" required>
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="item-status" class="form-label">Status</label>
                    <select class="form-select" id="item-status" name="status" required>
                        <option value="In Stock" {{ (old('status', $inventoryItem->status ?? '') == 'In Stock' ? 'selected' : '') }}>
                            In Stock
                        </option>
                        <option value="Low Stock" {{ (old('status', $inventoryItem->status ?? '') == 'Low Stock' ? 'selected' : '') }}>
                            Low Stock
                        </option>
                        <option value="Out of Stock" {{ (old('status', $inventoryItem->status ?? '') == 'Out of Stock' ? 'selected' : '') }}>
                            Out of Stock
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

