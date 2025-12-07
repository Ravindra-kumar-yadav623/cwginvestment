@extends('admin.layout')

@section('content')
<div class="container">
    <div class="page-inner">

        <div class="d-flex flex-md-row flex-column align-items-md-center pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-2">Welcome, {{ $user->name }}</h3>
                <h6 class="op-7 mb-2">Capital Wealth Growth</h6>
            </div>

            <div class="ms-md-auto">
                <div class="input-group mb-3">
                    <input type="text" class="form-control"
                        id="refLink"
                        value="{{ $referralLink }}"
                        readonly>
                    <button class="input-group-text btn-primary"
                        onclick="navigator.clipboard.writeText(document.getElementById('refLink').value)">
                        Copy Referral Link
                    </button>
                </div>
            </div>

            <div class="ms-md-auto">
                <a href="{{ route('deposit.create') }}" class="btn btn-primary">Deposit</a>
            </div>
        </div>

        {{-- Wallet Summary --}}
        <div class="row">
            <div class="col-md-3">
                <div class="card card-round card-stats">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <p class="card-category">Income Wallet</p>
                            <h4>${{ number_format($incomeWallet, 2) }}</h4>
                        </div>
                        <i class="fas fa-wallet fa-2x text-success"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-round card-stats">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <p class="card-category">Pocket Wallet</p>
                            <h4>${{ number_format($pocketWallet, 2) }}</h4>
                        </div>
                        <i class="fas fa-briefcase fa-2x text-info"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-round card-stats">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <p class="card-category">Total Income</p>
                            <h4>${{ number_format($totalIncome, 2) }}</h4>
                        </div>
                        <i class="fas fa-chart-line fa-2x text-primary"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-round card-stats">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <p class="card-category">Total Withdrawal</p>
                            <h4>${{ number_format($totalWithdrawal, 2) }}</h4>
                        </div>
                        <i class="fas fa-money-bill-wave fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Profile Info --}}
        <div class="card mt-4">
            <div class="card-header"><h4>User Info</h4></div>
            <div class="card-body">
                <table class="table">
                    <tr><td>User Code</td><td>{{ $user->user_code }}</td></tr>
                    <tr><td>Status</td><td>{{ ucfirst($user->status) }}</td></tr>
                    <tr><td>Country</td><td>{{ $user->country }}</td></tr>
                    <tr><td>Registered</td><td>{{ $user->created_at->format('d/m/Y h:i A') }}</td></tr>
                </table>
            </div>
        </div>

        {{-- Business --}}
        <div class="card mt-4">
            <div class="card-header"><h4>Network / Business</h4></div>
            <div class="card-body">
                <table class="table">
                    <tr><td>Direct Team</td><td>{{ $directTeamCount }}</td></tr>
                    <tr>
                        <td>Current Business (L/R)</td>
                        <td>${{ $leftRightBusiness['left'] }}/ ${{ $leftRightBusiness['right'] }}</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection