@extends('admin.layout')

@section('content')

<div class="container">
<div class="page-inner">

    <div class="page-header">
        <h3 class="fw-bold mb-3">Withdrawal History</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="{{ route('dashboard') }}">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">History</a>
            </li>
        </ul>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Withdrawal History</h4>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="withdrawalTable" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Amount (USDT)</th>
                            <th>Payout Method</th>
                            <th>Wallet Address</th>
                            <th>Status</th>
                            <th>Requested At</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($withdrawals as $withdraw)
                        <tr>
                            <td>${{ number_format($withdraw->amount, 2) }}</td>

                            <td>{{ $withdraw->payout_method ?? 'N/A' }}</td>

                            <td>
                                {{ $withdraw->payout_details['wallet_address'] ?? '-' }}
                            </td>

                            <td>
                                @switch($withdraw->status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                        @break
                                    @case('processing')
                                        <span class="badge bg-info text-dark">Processing</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-success">Completed</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                        @break
                                @endswitch
                            </td>

                            <td>{{ $withdraw->created_at->format('d/m/Y, g:i a') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No record found</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#withdrawalTable').DataTable();
    });
</script>
@endpush