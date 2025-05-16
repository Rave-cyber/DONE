<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Employees - Order #{{ $order->id }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(137.15deg, rgba(23, 232, 255, 0) 0%, rgba(23, 232, 255, 0.2) 100%);
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            margin-top: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #2F356D;
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
            background: #079CD6;
            border-radius: 2px;
        }
        .btn-primary {
            background: #079CD6;
            border: none;
        }
        .btn-primary:hover {
            background: #057baa;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ced4da;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-title">Assign Employees to Order #{{ $order->order_name }}</div>

        <form action="{{ route('orders.assign', $order->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="employee_ids">Select Employees:</label>
                <select name="employee_ids[]" id="employee_ids" class="form-control" multiple>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}"
                            {{ $order->employees->contains($employee->id) ? 'selected' : '' }}>
                            {{ $employee->getFullName() }} ({{ $employee->position ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
                @error('employee_ids')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Assign Employees
            </button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Cancel
            </a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#employee_ids').select2({
                placeholder: "Select employees",
                allowClear: true
            });
        });
    </script>
</body>
</html>