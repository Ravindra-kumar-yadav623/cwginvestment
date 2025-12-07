@extends('admin.layout')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Financial</h3>
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
                    <a href="#">Deposit History</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Deposit History</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                id="basic-datatables"
                                class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Amount (USDT)</th>
                                        <th>Date Time</th>
                                        <th>Deposit Address</th>
                                        <th>Proof Image</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @forelse($deposits as $deposit)
                                        <tr>
                                            {{-- Amount --}}
                                            <td>
                                                ${{ number_format($deposit->amount, 2) }}
                                            </td>

                                            {{-- Date Time --}}
                                            <td>
                                                {{ $deposit->created_at->format('d/m/Y, g:i a') }}
                                            </td>

                                            {{-- Deposit Address (system wallet address) --}}
                                            <td>
                                                {{ $deposit->request_wallet_address }}
                                            </td>

                                            {{-- Proof Image --}}
                                            <td>
                                                @if($deposit->proof_image)
                                                    <a href="{{ asset('storage/' . $deposit->proof_image) }}"
                                                       target="_blank">
                                                        <img src="{{ asset('storage/' . $deposit->proof_image) }}"
                                                             alt="Proof"
                                                             style="height:40px; width:auto; border-radius:4px;">
                                                    </a>
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>

                                            {{-- Status --}}
                                            <td>
                                                @if($deposit->status === 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($deposit->status === 'approved')
                                                    <span class="badge bg-success">Completed</span>
                                                @elseif($deposit->status === 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($deposit->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">
                                                No deposit records found.
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
    </div>
</div>
@endsection
