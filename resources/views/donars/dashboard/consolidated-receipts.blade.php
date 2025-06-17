@extends('donars.layouts.header')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Consolidated Receipts</h4>
                        </div>
                        <div class="card-body">
                            <form id="receiptForm" class="row g-3">
                                @csrf
                                @php
                                $startYear = 2025;
                                    $currentYear = now()->year;
                                    $currentMonth = now()->month;
                                
                                    // If before April, current financial year ends in previous year
                                    if ($currentMonth < 4) {
                                        $currentYear -= 1;
                                    }
                                @endphp
                                
                                <div class="col-md-6">
                                    <label for="financial_year" class="form-label">Financial Year</label>
                                    <select class="form-select" id="financial_year" name="financial_year" required>
                                        <option value="">Select Financial Year</option>
                                        @for ($year = $startYear; $year <= $currentYear; $year++)
                                            @php
                                                $nextYear = $year + 1;
                                                $value = "$year-04-01|$nextYear-03-31"; // format: start|end
                                            @endphp
                                            <option value="{{ $value }}">{{ $year }}–{{ $nextYear }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <input type="hidden" name="start_date" id="start_date">
                                <input type="hidden" name="end_date" id="end_date">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary" id="downloadBtn">
                                        <i class="fas fa-download me-2"></i>Download Consolidated Receipt
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Receipt Template (Hidden) -->
<div id="receiptTemplate" style="display: none;">
    <div class="receipt-container" style="padding: 20px; font-family: Arial, sans-serif;">
        <div class="receipt-header" style="text-align: center; margin-bottom: 30px;">
            <img src="https://gausevasociety.com/wp-content/uploads/2024/01/gaushala-logo.png" alt="Logo" style="max-width: 150px; margin-bottom: 10px;">
            <h2 style="margin: 0; color: #333;">Shree Ji Gau Sewa Society</h2>
            <p style="margin: 5px 0; color: #666;">Consolidated Receipt</p>
        </div>
        
        <div class="receipt-details" style="margin-bottom: 30px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span>Receipt No: <span id="receiptNo"></span></span>
                <span>Date: <span id="receiptDate"></span></span>
            </div>
            <div style="margin-bottom: 10px;">
                <p style="margin: 0;">Name: <span id="donorName"></span></p>
                <p style="margin: 0;">Address: <span id="donorAddress"></span></p>
            </div>
        </div>

        <div class="donation-details" style="margin-bottom: 30px;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Date</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Description</th>
                        <th style="padding: 10px; border: 1px solid #dee2e6;">Amount</th>
                    </tr>
                </thead>
                <tbody id="donationRows">
                    <!-- Donation rows will be inserted here -->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="padding: 10px; border: 1px solid #dee2e6; text-align: right;"><strong>Total Amount:</strong></td>
                        <td style="padding: 10px; border: 1px solid #dee2e6;"><strong id="totalAmount"></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="receipt-footer" style="text-align: center; margin-top: 50px;">
            <p style="margin: 0;">This is a computer generated receipt and does not require signature</p>
            <p style="margin: 5px 0;">For any queries, please contact: +91-XXXXXXXXXX</p>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script>
$(document).ready(function() {
    // Set default dates (current month)
    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    
    $('#start_date').val(firstDay.toISOString().split('T')[0]);
    $('#end_date').val(lastDay.toISOString().split('T')[0]);

    // Handle form submission
    $('#receiptForm').on('submit', function(e) {
        e.preventDefault();
        
        const startDate = $('#start_date').val();
        const endDate = $('#end_date').val();

        // Show loading state
        $('#downloadBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Generating Receipt...');

        // Make AJAX request to generate PDF
        $.ajax({
            url: '{{ route("donations.consolidated-receipt") }}',
            type: 'POST',
            data: {
                start_date: startDate,
                end_date: endDate,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Create a link and trigger download
                const link = document.createElement('a');
                link.href = response.pdf_url;
                link.download = `consolidated-receipt-${startDate}-to-${endDate}.pdf`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: function(xhr) {
                toastr.error('Error generating receipt. Please try again.');
            },
            complete: function() {
                $('#downloadBtn').prop('disabled', false).html('<i class="fas fa-download me-2"></i>Download Consolidated Receipt');
            }
        });
    });
});
</script>
<script>
    // On financial year selection, populate hidden start/end date inputs
    document.getElementById('financial_year').addEventListener('change', function () {
        const [start, end] = this.value.split('|');
        document.getElementById('start_date').value = start;
        document.getElementById('end_date').value = end;
    });
</script>
@endsection 