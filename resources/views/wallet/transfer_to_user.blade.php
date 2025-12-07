@extends('admin.layout')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Transfer</h3>
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
                    <a href="#">Transfer to Funds</a>
                </li>
            </ul>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->has('general'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ $errors->first('general') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            {{-- Left cards --}}
            <div class="col-md-5">
                <div class="card progress-card mb-3">
                    <div class="card-body d-flex">
                        <div class="me-auto">
                            <h4 class="card-title">Income Wallet</h4>
                            <div class="d-flex align-items-center">
                                <h2 class="fs-38 mb-0">$ {{ number_format($incomeBalance, 2) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card progress-card">
                    <div class="card-body d-flex">
                        <div class="me-auto">
                            <h4 class="card-title">Pocket Wallet</h4>
                            <div class="d-flex align-items-center">
                                <h2 class="fs-38 mb-0">$ {{ number_format($pocketBalance, 2) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right form --}}
            <div class="col-xl-7">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Transfer to Funds</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('wallet.transfer.user.submit') }}">
                            @csrf
                            <div class="basic-form">
                                {{-- Select Wallet --}}
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Select Wallet</label>
                                    <div class="col-sm-9">
                                        <select name="wallet_type"
                                                class="form-control @error('wallet_type') is-invalid @enderror">
                                            <option value="">Select--</option>
                                            <option value="commission" {{ old('wallet_type')=='commission' ? 'selected' : '' }}>Income Wallet</option>
                                            <option value="main" {{ old('wallet_type')=='main' ? 'selected' : '' }}>Pocket Wallet</option>
                                        </select>
                                        @error('wallet_type')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Transfer To User ID --}}
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Transfer To (User ID)</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               name="to_user_code"
                                               value="{{ old('to_user_code') }}"
                                               class="form-control @error('to_user_code') is-invalid @enderror"
                                               placeholder="Enter CWG User ID">
                                        @error('to_user_code')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Amount --}}
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Amount to be Transfer</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               name="amount"
                                               value="{{ old('amount') }}"
                                               class="form-control @error('amount') is-invalid @enderror"
                                               placeholder="Enter amount">
                                        @error('amount')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Transaction Password --}}
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Transaction Password</label>
                                    <div class="col-sm-9">
                                        <div class="input-group mb-3 input-primary">
                                            <input type="password"
                                                   name="transaction_password"
                                                   class="form-control @error('transaction_password') is-invalid @enderror"
                                                   placeholder="******">
                                            <span class="input-group-text"><i class="fa fa-eye-slash"></i></span>
                                        </div>
                                        @error('transaction_password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Remarks --}}
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Remarks</label>
                                    <div class="col-sm-9">
                                        <textarea name="remarks" rows="2" class="form-control">{{ old('remarks') }}</textarea>
                                    </div>
                                </div>

                                {{-- Checkbox --}}
                                <div class="mb-3 row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9">
                                        <div class="form-check">
                                            <input type="checkbox"
                                                   name="agree"
                                                   id="agree_user"
                                                   class="form-check-input"
                                                   {{ old('agree') ? 'checked' : '' }}>
                                            <label for="agree_user" class="form-check-label">Check me out</label>
                                        </div>
                                        @error('agree')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Buttons --}}
                                <div class="mb-3 row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 d-flex gap-2">
                                        <button type="submit"
                                                class="btn btn-outline-primary"
                                                formaction="{{ route('wallet.transfer.user.sendOtp') }}">
                                            Send OTP
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>{{-- row --}}
    </div>
</div>

{{-- OTP MODAL --}}
<div class="modal fade" id="userTransferOtpModal" tabindex="-1" aria-labelledby="userTransferOtpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="{{ route('wallet.transfer.user.submit') }}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="userTransferOtpModalLabel">Verify OTP</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p class="text-muted">Enter the OTP sent to your registered email.</p>
            <div class="mb-3">
                <label class="form-label">One Time Password</label>
                <input type="text"
                       name="otp"
                       class="form-control @error('otp') is-invalid @enderror"
                       placeholder="6 digit OTP">
                @error('otp')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-check">
                <input type="checkbox"
                       name="agree"
                       id="agree_user_modal"
                       class="form-check-input"
                       {{ old('agree') ? 'checked' : '' }}>
                <label for="agree_user_modal" class="form-check-label">Check me out</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Confirm Transfer</button>
          </div>
        </div>
    </form>
  </div>
</div>

@if(session('show_user_transfer_otp_modal') || $errors->has('otp'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let m = new bootstrap.Modal(document.getElementById('userTransferOtpModal'));
        m.show();
    });
</script>
@endif
@endsection
