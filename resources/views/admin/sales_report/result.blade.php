@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Sales Report: {{ $startDate }} to {{ $endDate }}</h2>
    
    <div class="mb-4">
        <button id="exportPdf" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Export to PDF
        </button>
        <button id="exportExcel" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Export to Excel
        </button>
    </div>
    
    <div class="summary mb-4">
        <h4>Service Totals</h4>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Wash</h5>
                        <p>₱{{ number_format($totals['Wash'], 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Fold</h5>
                        <p>₱{{ number_format($totals['Fold'], 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Ironing</h5>
                        <p>₱{{ number_format($totals['Ironing'], 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Total</h5>
                        <p>₱{{ number_format($totals['All'], 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="report-content">
        <table class="table table-striped" id="sales-table">
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
                    <td>
                        @foreach((array)$order->service_type as $service)
                            {{ $service }}<br>
                        @endforeach
                    </td>
                    <td>{{ $order->status }}</td>
                    <td>₱{{ number_format($order->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('exportPdf').addEventListener('click', function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        
        const title = `Sales Report: {{ $startDate }} to {{ $endDate }}`;
        
        doc.setFontSize(18);
        doc.text(title, 14, 15);
        
        doc.setFontSize(10);
        doc.text(`Generated on: ${new Date().toLocaleString()}`, 14, 22);
        
        const summaryData = [
            ['Service', 'Amount'],
            ['Wash', '₱{{ number_format($totals["Wash"], 2) }}'],
            ['Fold', '₱{{ number_format($totals["Fold"], 2) }}'],
            ['Ironing', '₱{{ number_format($totals["Ironing"], 2) }}'],
            ['Total', '₱{{ number_format($totals["All"], 2) }}']
        ];
        
        doc.autoTable({
            startY: 30,
            head: [summaryData[0]],
            body: summaryData.slice(1),
            theme: 'grid',
            headStyles: { fillColor: [22, 160, 133] }
        });
        
        const tableData = [];
        const headers = ['Order ID', 'Customer', 'Date', 'Services', 'Status', 'Amount'];
        
        @foreach($orders as $order)
            tableData.push([
                '{{ $order->id }}',
                '{{ $order->order_name }}',
                '{{ $order->date }}',
                `{{ implode(", ", (array)$order->service_type) }}`,
                '{{ $order->status }}',
                '₱{{ number_format($order->amount, 2) }}'
            ]);
        @endforeach
        
        // Add orders table
        doc.autoTable({
            startY: doc.lastAutoTable.finalY + 20,
            head: [headers],
            body: tableData,
            theme: 'grid',
            headStyles: { fillColor: [41, 128, 185] },
            styles: { fontSize: 8 },
            columnStyles: {
                0: { cellWidth: 15 },
                1: { cellWidth: 30 },
                2: { cellWidth: 25 },
                3: { cellWidth: 40 },
                4: { cellWidth: 20 },
                5: { cellWidth: 20 }
            }
        });
        
        doc.save(`Sales_Report_{{ $startDate }}_to_{{ $endDate }}.pdf`);
    });
    
    document.getElementById('exportExcel').addEventListener('click', function() {
        const wb = XLSX.utils.book_new();
        
        const summaryData = [
            ['Sales Report: {{ $startDate }} to {{ $endDate }}'],
            ['Generated on:', new Date().toLocaleString()],
            [],
            ['Service', 'Amount'],
            ['Wash', {{ $totals['Wash'] }}],
            ['Fold', {{ $totals['Fold'] }}],
            ['Ironing', {{ $totals['Ironing'] }}],
            ['Total', {{ $totals['All'] }}],
            [],
            ['Order ID', 'Customer', 'Date', 'Services', 'Status', 'Amount']
        ];
        
        // Add orders data
        @foreach($orders as $order)
            summaryData.push([
                {{ $order->id }},
                '{{ $order->order_name }}',
                '{{ $order->date }}',
                `{{ implode(", ", (array)$order->service_type) }}`,
                '{{ $order->status }}',
                {{ $order->amount }}
            ]);
        @endforeach

        const ws = XLSX.utils.aoa_to_sheet(summaryData);
        
        XLSX.utils.book_append_sheet(wb, ws, "Sales Report");
        
        XLSX.writeFile(wb, `Sales_Report_{{ $startDate }}_to_{{ $endDate }}.xlsx`);
    });
});
</script>

<style>
    .btn {
        margin-right: 10px;
    }
    .card {
        margin-bottom: 20px;
    }
    .card-body h5 {
        font-size: 1rem;
        font-weight: bold;
    }
    .card-body p {
        font-size: 1.2rem;
        color: #2c3e50;
    }
</style>
@endsection