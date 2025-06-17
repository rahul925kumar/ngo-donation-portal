@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="dashboard-stats">
    <div class="stat-card wallet">
        <span class="icon"><i class="bi bi-wallet2"></i></span>
        <div>
            <div class="stat-label">Total Donations</div>
            <div class="stat-value">₹{{ number_format($totalDonationCount ?? 0, 2) }}</div>
        </div>
        <span class="lock-icon"><i class="bi bi-lock"></i></span>
    </div>
    <div class="stat-card count">
        <span class="icon"><i class="bi bi-people"></i></span>
        <div>
            <div class="stat-label">Donor Count</div>
            <div class="stat-value"><i class="fa fa-user" aria-hidden="true"></i> &nbsp;{{ $totalUsers ?? 0 }}</div>
        </div>
        <span class="cart-icon"><i class="bi bi-cart"></i></span>
    </div>
    <div class="stat-card volume">
        <span class="icon"><i class="bi bi-cash-stack"></i></span>
        <div>
            <div class="stat-label">Number of Donations</div>
            <div class="stat-value">{{ $pendingDonation + $completeDonation }}</div>
        </div>
        <span class="lock-icon"><i class="bi bi-lock"></i></span>
    </div>
</div>

<div class="dashboard-table-card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span>Payout Txn Details <span class="badge bg-primary">{{ ($certificateDonationsCount + $totalDonations) ?? 0 }}</span></span>
    </div>
    <div class="card-body">
        <div class="txn-status-row">
            <div class="status-box status-success">Success<br><span>{{ $completeDonation ?? 0 }}</span></div>
            <div class="status-box status-pending">Pending<br><span>{{ $pendingDonation ?? 0 }}</span></div>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentDonations as $donation)
                    <tr>
                        <td>{{ urldecode($donation->name) }}</td>
                        <td>₹{{ number_format($donation->amount, 2) }}</td>
                        <td>{{ $donation->created_on }}</td>
                        <td>
                            <span class="badge 
                                @if($donation->payment_status === 'completed') badge-success
                                @elseif($donation->payment_status === 'pending') badge-warning
                                @elseif($donation->payment_status === 'failed') badge-danger
                                @else badge-info @endif">
                                {{ ucfirst($donation->payment_status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection