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
                    <a href="#">Deposit</a>
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

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Deposit</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ route('deposit.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                {{-- Deposit Request For --}}
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">
                                        Deposit Request For <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="request_for" class="form-control @error('request_for') is-invalid @enderror">
                                            <option value="">Select--</option>
                                            @foreach($requestForOptions as $opt)
                                                <option value="{{ $opt['label'] }}"
                                                    {{ old('request_for') == $opt['label'] ? 'selected' : '' }}
                                                    data-address="{{ $opt['address'] }}">
                                                    {{ $opt['label'] }} ({{ $opt['address'] }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('request_for')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror

                                        {{-- hidden field to store selected wallet address --}}
                                        <input type="hidden" name="request_wallet" id="request_wallet" value="{{ old('request_wallet') }}">
                                    </div>
                                </div>

                                {{-- Select Currency --}}
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">
                                        Select Currency <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="currency" class="form-control @error('currency') is-invalid @enderror">
                                            @foreach($currencies as $value => $label)
                                                <option value="{{ $value }}" {{ old('currency', $value) == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('currency')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Amount --}}
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">
                                        Amount (USDT) <span class="text-danger">*</span>
                                    </label>
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

                                {{-- User Crypto Address --}}
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">
                                        Your Crypto Address <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               name="user_crypto_address"
                                               value="{{ old('user_crypto_address') }}"
                                               class="form-control @error('user_crypto_address') is-invalid @enderror"
                                               placeholder="Enter your crypto address">
                                        @error('user_crypto_address')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Upload Image --}}
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">
                                        Upload Proof Image <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="file"
                                               name="proof_image"
                                               class="form-control @error('proof_image') is-invalid @enderror">
                                        @error('proof_image')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">
                                            Upload screenshot of transaction / payment proof (max 2MB).
                                        </small>
                                    </div>
                                </div>

                                {{-- Terms --}}
                                <div class="mb-3 row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9">
                                        <div class="form-check">
                                            <input type="checkbox"
                                                   name="terms"
                                                   id="basic_checkbox_1"
                                                   class="form-check-input"
                                                   {{ old('terms') ? 'checked' : '' }}
                                                   required>
                                            <label class="form-check-label" for="basic_checkbox_1">
                                                I confirm that the above payment details are correct.
                                            </label>
                                        </div>
                                        @error('terms')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">
                                            Deposit
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div> {{-- basic-form --}}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Auto-fill wallet address based on "Deposit Request For" --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectReqFor = document.querySelector('select[name="request_for"]');
    const hiddenWallet = document.getElementById('request_wallet');

    if (selectReqFor && hiddenWallet) {
        function updateWallet() {
            const opt = selectReqFor.options[selectReqFor.selectedIndex];
            hiddenWallet.value = opt.getAttribute('data-address') || '';
        }
        selectReqFor.addEventListener('change', updateWallet);
        updateWallet();
    }
});
</script>
@endsection
