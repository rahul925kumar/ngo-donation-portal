@extends('admin.layouts.app')

@section('title', 'Donations Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Donations List</h5>
    </div>
    <div class="card-body">
        <div class="mb-3 d-flex gap-3 align-items-center">
            <div class="d-flex gap-2 align-items-center">
                <label for="startDate" class="mb-0">From:</label>
                <input type="date" id="startDate" class="form-control">
            </div>
            <div class="d-flex gap-2 align-items-center">
                <label for="endDate" class="mb-0">To:</label>
                <input type="date" id="endDate" class="form-control">
            </div>
            <button id="exportCsv" class="btn btn-primary">
                <i class="fas fa-receipt"></i> Export to CSV
            </button>
            <button id="exportPdf" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export as PDF
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped" id="donationsTable">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Payment ID</th>
                        <th> <i class="fas fa-download"></i> Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations['donation'] as $donation)
                    <tr>
                        <td>{{ urldecode($donation->name) }}</td>
                        <td>₹{{$donation->amount}}</td>
                        <td>{{ date('Y-m-d', strtotime($donation->created_on)) }}</td>
                        <td>{{$donation->payment_status}}</td>
                        <td>{{$donation->payment_id}}</td>
                       <td><a href="{{ route('admin.users.receipts.download', ['user_id' => $donation->id, 'donation_id' => $donation->donation_id]) }}?table_name=donation" target="_blank">Receipt</a></td>
                    </tr>
                    @endforeach
                    @foreach($donations['certificate_donation'] as $donation)
                    <tr>
                        <td>{{ urldecode($donation->name) }}</td>
                        <td>₹{{$donation->amount}}</td>
                        <td>{{ date('Y-m-d', strtotime($donation->created_on)) }}</td>
                        <td>{{$donation->payment_status}}</td>
                        <td>{{$donation->payment_id}}</td>
                       <td><a href="{{ route('admin.users.receipts.download', ['user_id' => $donation->id, 'donation_id' => $donation->donation_id]) }}?table_name=certificate_donation" target="_blank">Receipt</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="toastAlert" class="toast text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body" id="toastMessage">Success!</div>
    </div>
</div>


@push('scripts')
<script>
    $(document).ready(function() {
        var donationsTable = $('#donationsTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    className: 'btn btn-primary',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'pdf',
                    text: 'Export as PDF',
                    className: 'btn btn-danger',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }
            ]
        });

        // Set default date range to current month
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        
        $('#startDate').val(firstDay.toISOString().split('T')[0]);
        $('#endDate').val(lastDay.toISOString().split('T')[0]);

        // Filter table based on date range
        function filterTableByDate() {
            const startDate = new Date($('#startDate').val());
            const endDate = new Date($('#endDate').val());
            
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                const rowDate = new Date(data[2]); // Date is in column 2
                return (rowDate >= startDate && rowDate <= endDate);
            });
            
            donationsTable.draw();
            
            // Remove the custom filter after applying it
            $.fn.dataTable.ext.search.pop();
        }

        $('#startDate, #endDate').on('change', filterTableByDate);

        // Apply initial filter
        filterTableByDate();

        $('#exportCsv').on('click', function() {
            // Get the filtered data
            const filteredData = donationsTable.rows({ search: 'applied' }).data();
            
            // Prepare the CSV content
            let csvContent = "User,Amount,Date,Status,Payment ID\n";
            
            // Add each row to the CSV
            filteredData.each(function(row) {
                csvContent += row[0] + "," + row[1] + "," + row[2] + "," + row[3] + "," + row[4] + "\n";
            });

            // Create and download the CSV file
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement("a");
            link.setAttribute("href", url);
            link.setAttribute("download", "donations.csv");
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        $('#exportPdf').on('click', function() {
            // Get the filtered data
            const filteredData = donationsTable.rows({ search: 'applied' }).data();
            
            // Convert DataTables data to array
            const tableData = [];
            filteredData.each(function(row) {
                tableData.push([row[0], row[1], row[2], row[3], row[4]]);
            });
            
            // Create PDF content
            const docDefinition = {
                content: [
                    { text: 'Donations Report', style: 'header' },
                    { text: `Date Range: ${$('#startDate').val()} to ${$('#endDate').val()}`, style: 'subheader' },
                    {
                        table: {
                            headerRows: 1,
                            widths: ['*', 'auto', 'auto', 'auto', 'auto'],
                            body: [
                                ['User', 'Amount', 'Date', 'Status', 'Payment ID'],
                                ...tableData
                            ]
                        }
                    }
                ],
                styles: {
                    header: {
                        fontSize: 18,
                        bold: true,
                        margin: [0, 0, 0, 10]
                    },
                    subheader: {
                        fontSize: 14,
                        bold: true,
                        margin: [0, 10, 0, 5]
                    }
                }
            };

            // Generate and download PDF
            pdfMake.createPdf(docDefinition).download('donations.pdf');
        });
    });

    function showToast(message, type = 'success') {
        const toastEl = $('#toastAlert');
        const toastBody = $('#toastMessage');
        toastBody.text(message);
        toastEl.removeClass('text-bg-success text-bg-danger').addClass(`text-bg-${type}`);
        const toast = new bootstrap.Toast(toastEl[0]);
        toast.show();
    }
</script>
@endpush
@endsection
