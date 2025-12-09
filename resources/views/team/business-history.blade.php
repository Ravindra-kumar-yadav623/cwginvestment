@extends('admin.layout')

@section('content')
<div class="container">
    <div class="page-inner">

        <div class="page-header">
            <h3 class="fw-bold mb-3">Business History</h3>
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
                    <a href="#">Sponsor Income</a>
                </li>
            </ul>
        </div>

        {{-- Summary --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <p class="card-category mb-1">Total Sponsor Income</p>
                            <h4 class="card-title mb-0">
                                ${{ number_format($totalSponsorIncome, 2) }}
                            </h4>
                        </div>
                        <div class="icon-big text-center icon-success bubble-shadow-small">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Sponsor Income History</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables"
                                   class="display table table-striped table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>From User</th>
                                        <th>User Code</th>
                                        <th>Income (USDT)</th>
                                        <th>Reference No</th>
                                        <th>Date &amp; Time</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sponsorIncomes as $index => $tx)
                                        @php
                                            $from = $tx->fromUser;
                                        @endphp
                                        <tr>
                                            <td>{{ $sponsorIncomes->firstItem() + $index }}</td>

                                            <td>
                                                {{ $from->name ?? 'N/A' }}<br>
                                                <small class="text-muted">
                                                    {{ $from->email ?? '' }}
                                                </small>
                                            </td>

                                            <td>{{ $from->user_code ?? '-' }}</td>

                                            <td>
                                                ${{ number_format($tx->amount, 4) }}
                                            </td>

                                            <td>{{ $tx->reference_no ?? '-' }}</td>

                                            <td>{{ $tx->created_at->format('d/m/Y, g:i a') }}</td>

                                            <td>{{ $tx->remark ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                No sponsor income yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Laravel pagination (if you want in addition to DataTables) --}}
                        <div class="mt-3">
                            {{ $sponsorIncomes->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection