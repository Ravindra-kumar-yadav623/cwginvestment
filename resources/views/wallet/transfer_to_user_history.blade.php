@extends('admin.layout')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Transfer to User History</h3>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Outgoing Transfers</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>User Code</th>
                                <th>Amount (USDT)</th>
                                <th>Reference</th>
                                <th>From Wallet</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $tx)
                                <tr>
                                    <td>{{ $tx->created_at->format('d/m/Y, g:i a') }}</td>
                                    <td>{{ $tx->user->user_code }}</td>
                                    <td>${{ number_format($tx->amount, 2) }}</td>
                                    <td>{{ $tx->reference_no }}</td>
                                    <td>{{ $tx->wallet->type == 'commission' ? 'Income Wallet' : 'Pocket Wallet' }}</td>
                                    <td>{{ $tx->remark }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No transfer records found.
                                    </td>
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
