@extends('admin.layout')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Received Funds History</h3>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Funds Received</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount (USDT)</th>
                                <th>Sender User Code</th>
                                <th>Wallet</th>
                                <th>Reference</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $tx)
                                <tr>
                                    <td>{{ $tx->created_at->format('d/m/Y, g:i a') }}</td>
                                    <td>${{ number_format($tx->amount, 2) }}</td>

                                    {{-- Sender: find from remark --}}
                                    <td>
                                        @php
                                            preg_match('/\bCWG\d+\b/', $tx->remark, $match);
                                            echo $match[0] ?? 'Unknown';
                                        @endphp
                                    </td>

                                    <td>
                                        {{ $tx->wallet->type == 'main' ? 'Pocket Wallet' : ucfirst($tx->wallet->type).' Wallet' }}
                                    </td>

                                    <td>{{ $tx->reference_no }}</td>
                                    <td>{{ $tx->remark }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No received transfers found.
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
