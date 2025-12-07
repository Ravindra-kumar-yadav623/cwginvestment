@extends('admin.layout')

@section('content')

<div class="container">
    <div class="container page-inner">

        <div class="page-header">
            <h3 class="fw-bold mb-3">Withdrawal</h3>
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
                    <a href="#">Withdrawal</a>
                </li>
            </ul>
        </div>

        <div class="row">

            {{-- Wallet Balances --}}
            <div class="col-md-4">
                <div class="card progress-card">
                    <div class="card-body">
                        <h4>Balances</h4>

                        <p class="mb-0">
                            <strong>Income Wallet:</strong>
                            ${{ number_format($incomeWallet ?? 0, 2) }}
                            <br>
                            <strong>Investment Wallet:</strong>
                            ${{ number_format($investmentWallet ?? 0, 2) }}
                        </p>

                    </div>
                </div>
            </div>

            {{-- Withdrawal Form --}}
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Withdrawal Request</h4>
                    </div>

                    <div class="card-body">

                        {{-- Status Alerts --}}
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                        </div>
                        @endif

                        {{-- Form --}}
                        <form method="POST" action="{{ route('withdrawal.sendOtp') }}">
                            @csrf

                            {{-- Wallet --}}
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Select Wallet *</label>
                                <div class="col-sm-9">
                                    <select name="wallet_type" class="form-control" required>
                                        <option value="">Select Wallet--</option>
                                        <option value="commission">Income Wallet</option>
                                        <option value="investment">Investment Wallet</option>
                                    </select>
                                    @error('wallet_type')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>

                            {{-- Amount --}}
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Enter Amount *</label>
                                <div class="col-sm-9">
                                    <input type="number" step="0.01" name="amount" class="form-control" required>
                                    @error('amount')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Transaction Password --}}
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Transaction Password *</label>
                                <div class="col-sm-9">
                                    <input type="password" name="transaction_password" class="form-control  @error('transaction_password') is-invalid @enderror" placeholder="******" required>
                                    @error('transaction_password')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary">Send OTP</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- OTP Modal --}}
@if(session('show_otp_modal'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let modal = new bootstrap.Modal(document.getElementById('otpModal'));
        modal.show();
    });
</script>
@endif

<div class="modal fade" id="otpModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('withdrawal.submit') }}">
            @csrf
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Withdraw - Verify OTP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="text-secondary">
                        OTP sent to <strong>{{ auth()->user()->email }}</strong>
                    </p>

                    {{-- OTP --}}
                    <div class="mb-3">
                        <label class="mb-1">Enter OTP *</label>
                        <input type="text" name="otp" class="form-control" placeholder="6 Digit OTP">
                        @error('otp')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-check mb-2">
                        <input type="checkbox" name="agree" class="form-check-input" required>
                        <label class="form-check-label">
                            I agree withdrawal cannot be cancelled once submitted.
                        </label>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Confirm Withdrawal</button>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection