@extends('admin.layout')

@section('content')
<div class="container">
    <div class="page-inner">

        <div class="mb-4">
            <div class="card">
                <div class="card-body">
                    <h4>Pocket Wallet Balance</h4>
                    <h2 class="mt-2">${{ number_format($balance, 2) }}</h2>
                </div>
            </div>
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

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Transfer Fund to CWG Investment</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('wallet.transfer.submit') }}">
                    @csrf

                    {{-- Select Wallet --}}
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Select Wallet</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="Pocket Wallet" readonly>
                            <input type="hidden" name="wallet_type" value="main">
                        </div>
                    </div>

                    {{-- Transfer To (User ID) --}}
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Transfer To (User ID)</label>
                        <div class="col-sm-9">
                            <input type="text"
                                   class="form-control"
                                   value="{{ $user->user_code }}"
                                   readonly>
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
                            <input type="password"
                                   name="transaction_password"
                                   class="form-control @error('transaction_password') is-invalid @enderror"
                                   placeholder="******">
                            @error('transaction_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Remarks --}}
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Remarks</label>
                        <div class="col-sm-9">
                            <textarea name="remarks" rows="3" class="form-control">{{ old('remarks') }}</textarea>
                        </div>
                    </div>

                    {{-- Checkbox --}}
                    <div class="mb-3 row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input type="checkbox"
                                       name="agree"
                                       id="agree"
                                       class="form-check-input"
                                       {{ old('agree') ? 'checked' : '' }}>
                                <label for="agree" class="form-check-label">Check me out</label>
                            </div>
                            @error('agree')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Buttons: Send OTP + Submit --}}
                    <div class="mb-3 row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9 d-flex gap-2">
                            <button type="submit"
                                    class="btn btn-outline-primary"
                                    formaction="{{ route('wallet.transfer.sendOtp') }}">
                                Send OTP
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

{{-- OTP MODAL --}}
<div class="modal fade" id="transferOtpModal" tabindex="-1" aria-labelledby="transferOtpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="{{ route('wallet.transfer.submit') }}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="transferOtpModalLabel">Verify OTP</h5>
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
                       id="agree_modal"
                       class="form-check-input"
                       {{ old('agree') ? 'checked' : '' }}>
                <label for="agree_modal" class="form-check-label">
                    Check me out
                </label>
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

@if(session('show_transfer_otp_modal') || $errors->has('otp'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let modal = new bootstrap.Modal(document.getElementById('transferOtpModal'));
            modal.show();
        });
    </script>
@endif
@endsection