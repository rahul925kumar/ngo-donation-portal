@extends('admin.layouts.app')

@section('title', 'Donations Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Donations List</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <button id="exportCsv" class="btn btn-primary">
                <i class="fas fa-receipt"></i>  Export to CSV
            </button>
            <button id="downloadBulkReceipts" class="btn btn-danger">
    <i class="fas fa-file-pdf me-1"></i> Download Receipts</button>

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
            order: [] // Disable initial sorting
        });

        $('#exportCsv').on('click', function() {
            // Get the data from the table
            var data = donationsTable.rows().data();

            // Prepare the CSV header
            var csvContent = "User,Amount,Date,Status,Payment ID\n";

            // Loop through the data and append each row to the CSV content
            data.each(function(row) {
                csvContent += row[0] + "," + row[1] + "," + row[2] + "," + row[3] + "," + row[4] + "\n";
            });

            // Create a Blob object from the CSV content
            var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            var url = URL.createObjectURL(blob);

            // Create a link and simulate a click to trigger the download
            var link = document.createElement("a");
            link.setAttribute("href", url);
            link.setAttribute("download", "donations.csv");
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });
</script>
<script>
    function getUserIdFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('user');
}

    $('#downloadBulkReceipts').click(function () {
       const userId = getUserIdFromUrl();

        if (!userId) {
            return alert('User ID not available.');
        }

        const url = "{{ route('admin.users.receipts.download.bulk') }}";

        // Show loading indicator
        let button = $(this);
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Downloading...');

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                user_id: userId,
                table_name: 'donation' // or 'certificate_donation' if needed
            },
            xhrFields: {
                responseType: 'blob' // Expecting a binary file
            },
            success: function (data, status, xhr) {
                const blob = new Blob([data], { type: 'application/zip' });
                const downloadUrl = URL.createObjectURL(blob);

                const a = document.createElement('a');
                a.href = downloadUrl;
                a.download = "bulk_receipts_user_" + userId + ".zip";
                document.body.appendChild(a);
                a.click();
                a.remove();

                URL.revokeObjectURL(downloadUrl);
                showToast('Download started.', 'success');
            },
            error: function (xhr) {
                let message = 'Something went wrong.';
                if (xhr.responseJSON?.error) {
                    message = xhr.responseJSON.error;
                }
                showToast(message, 'danger');
            },
            complete: function () {
                button.prop('disabled', false).html('<i class="fas fa-file-pdf me-1"></i> Download Bulk Receipts');
            }
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
