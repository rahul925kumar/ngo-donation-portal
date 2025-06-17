@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .dashboard-header {
        background: #4B2AAD;
        color: #fff;
        padding: 1.5rem 2rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 10px;
    }
    .dashboard-stats {
        display: flex;
        gap: 2rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        flex: 1;
        border-radius: 1.2rem;
        box-shadow: 0 2px 12px rgba(75,42,173,0.07);
        padding: 2rem 1.5rem;
        display: flex;
        align-items: center;
        background: linear-gradient(90deg, #f3eaff 60%, #ede7f6 100%);
        position: relative;
    }
    .stat-card .icon {
        font-size: 2.5rem;
        margin-right: 1.2rem;
        color: #4B2AAD;
    }
    .stat-card .stat-label {
        font-size: 1.1rem;
        color: #888;
        margin-bottom: 0.2rem;
    }
    .stat-card .stat-value {
        font-size: 2.2rem;
        font-weight: 700;
        color: #222;
    }
    .stat-card.wallet { background: linear-gradient(90deg, #f3eaff 60%, #ede7f6 100%); }
    .stat-card.count { background: linear-gradient(90deg, #eafff3 60%, #e7f6ed 100%); }
    .stat-card.volume { background: linear-gradient(90deg, #fff7ea 60%, #f6f0e7 100%); }
    .stat-card .lock-icon, .stat-card .cart-icon { position: absolute; right: 1.5rem; top: 1.5rem; font-size: 1.5rem; color: #b39ddb; }
    .stat-card .cart-icon { color: #4caf50; }
    .stat-card .lock-icon { color: #b39ddb; }
    .dashboard-table-card {
        border-radius: 1.2rem;
        box-shadow: 0 2px 12px rgba(75,42,173,0.07);
        margin-top: 2rem;
        background: #fff;
    }
    .dashboard-table-card .card-header {
        background: none;
        border-bottom: 1px solid #eee;
        font-weight: 600;
        font-size: 1.2rem;
        color: #4B2AAD;
    }
    .dashboard-table-card .table {
        margin-bottom: 0;
    }
    .badge-success { background: #4caf50 !important; color: #fff; }
    .badge-warning { background: #ffb300 !important; color: #fff; }
    .badge-danger { background: #f44336 !important; color: #fff; }
    .badge-info { background: #7c4dff !important; color: #fff; }
    .txn-status-row {
        display: flex;
        justify-content: space-between;
        margin: 1.5rem 0 0.5rem 0;
    }
    .txn-status-row .status-box {
        flex: 1;
        text-align: center;
        padding: 0.7rem 0;
        border-radius: 2rem;
        margin: 0 0.5rem;
        font-weight: 600;
        font-size: 1.1rem;
    }
    .status-success { background: #e8f5e9; color: #388e3c; }
    .status-pending { background: #fffde7; color: #fbc02d; }
    .status-failed { background: #ffebee; color: #d32f2f; }
    .status-refund { background: #ede7f6; color: #7c4dff; }
</style>

<div class="dashboard-stats">
    <div class="stat-card wallet">
        <span class="icon"><i class="bi bi-wallet2"></i></span>
        <div>
            <div class="stat-label">Total Donations</div>
            <div class="stat-value">₹{{ number_format($walletBalance ?? 0, 2) }}</div>
        </div>
        <span class="lock-icon"><i class="bi bi-lock"></i></span>
    </div>
    <div class="stat-card count">
        <span class="icon"><i class="bi bi-people"></i></span>
        <div>
            <div class="stat-label">Total Count</div>
            <div class="stat-value">{{ $totalCount ?? 0 }}</div>
        </div>
        <span class="cart-icon"><i class="bi bi-cart"></i></span>
    </div>
    <div class="stat-card volume">
        <span class="icon"><i class="bi bi-cash-stack"></i></span>
        <div>
            <div class="stat-label">Payout Total Volume</div>
            <div class="stat-value">₹{{ number_format($totalVolume ?? 0, 2) }}</div>
        </div>
        <span class="lock-icon"><i class="bi bi-lock"></i></span>
    </div>
</div>

<div class="dashboard-table-card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span>Payout Txn Details <span class="badge bg-primary">{{ $totalCount ?? 0 }}</span></span>
    </div>
    <div class="card-body">
        <div class="txn-status-row">
            <div class="status-box status-success">Success<br><span>{{ $successCount ?? 0 }}</span></div>
            <div class="status-box status-pending">Pending<br><span>{{ $pendingCount ?? 0 }}</span></div>
            <div class="status-box status-failed">Failed<br><span>{{ $failedCount ?? 0 }}</span></div>
            <div class="status-box status-refund">Refund<br><span>{{ $refundCount ?? 0 }}</span></div>
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