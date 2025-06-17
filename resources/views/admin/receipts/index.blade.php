@extends('admin.layouts.app')

@section('title', 'Receipts Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Receipts List</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <button id="exportCsv" class="btn btn-info">
                <i class="fas fa-receipt"></i>
            </button>
            <button id="addReceiptBtn" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Add Receipt
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped" id="receiptsTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Receipt</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($receipts as $receipt)
                    <tr>
                        <td>{{ $receipt->name }}</td>
                        <td>{{ $receipt->email }}</td>
                        <td>{{ $receipt->phone_number }}</td>
                        <td>₹{{ $receipt->amount }}</td>
                        <td>{{ $receipt->payment_method }}</td>
                        <td><a href="https://gausevasociety.com/donation-portal/admin/download-reciept/{{$receipt->id}}" target="_blank">Download</a></td>
                        <td>{{ date('Y-m-d', strtotime($receipt->created_at)) }}</td>
                        <td><a href="https://gausevasociety.com/donation-portal/admin/reciepts/delete/{{$receipt->id}}" class="btn btn-danger">Delete</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addReceiptModal" tabindex="-1" aria-labelledby="addReceiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-semibold" id="addReceiptModalLabel">🧾 Add New Receipt</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-4 py-3">
                <form id="addReceiptForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>

                        <div class="col-md-6">
                            <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                        </div>

                        <div class="col-md-6">
                            <label for="pan" class="form-label">PAN <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="pan" name="pan" required>
                        </div>

                        <div class="col-md-6">
                            <label for="adhar_card" class="form-label">Aadhar Card Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="adhar_card" name="adhar_card" required>
                        </div>

                        <div class="col-md-6">
                            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="2"></textarea>
                        </div>

                        <div class="col-12">
                            <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="">-- Select Payment Method --</option>
                                <option value="online">Online</option>
                                <option value="cash">Cash</option>
                                <option value="upi">UPI</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer bg-light px-4 py-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </button>
                <button type="submit" class="btn btn-primary" id="saveReceiptBtn">
                    <i class="bi bi-save2 me-1"></i> Save Receipt
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

<!-- jQuery (Required for Toastr) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


@push('scripts')
<script>
    $(document).ready(function() {
        var receiptsTable = $('#receiptsTable').DataTable();

        $('#addReceiptBtn').on('click', function() {
            $('#addReceiptModal').modal('show');
        });

        $('#saveReceiptBtn').on('click', function() {
            var formData = $('#addReceiptForm').serialize();

            $.ajax({
                url: "{{ route('admin.receipts.store') }}",
                method: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Include CSRF token here
                },
                success: function(response) {
                    if (response.success) {
                        $('#addReceiptModal').modal('hide');
                        $('#addReceiptForm')[0].reset();
                        // receiptsTable.ajax.reload();
                        toastr.success(response.message);
                        window.location.reload();

                    } else {
                        toastr.error(response.message);
                         if (response.errors) {
                            $.each(response.errors, function(key, value) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).next('.invalid-feedback').remove();
                                $('#' + key).after('<div class="invalid-feedback">' + value + '</div>');
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", xhr, status, error);
                    toastr.error("An error occurred. Please try again.");
                }
            });
        });
        $('#exportCsv').on('click', function() {
            var data = receiptsTable.rows().data();
            var csvContent = "Name,Email,Phone,Amount,Payment Method,Receipt,Date\n";
            data.each(function(row) {
                csvContent += row[0] + "," + row[1] + "," + row[2] + "," + row[3] + "," + row[4] + ","+row[5] + ","+row[5] + "\n";
            });
            var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            var url = URL.createObjectURL(blob);
            var link = document.createElement("a");
            link.setAttribute("href", url);
            link.setAttribute("download", "receipts.csv");
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });
</script>
@endpush
@endsection
