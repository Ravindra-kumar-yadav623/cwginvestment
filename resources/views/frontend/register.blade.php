 {{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Capital Wealth Growth - Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS (if not already included) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-dark text-white">
                    <h4 class="mb-0">Capital Wealth Growth</h4>
                    <small>Network Marketing Registration</small>
                </div>

                <div class="card-body">

                    {{-- Success message --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

					@if($errors->any())
						<div class="alert alert-danger">
							<ul class="mb-0">
								@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
								oninput="this.value=this.value.toLowerCase()"       
								value="{{ old('email') }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Mobile --}}
                        <div class="mb-3">
                            <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror"
                                   value="{{ old('mobile') }}" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                            @error('mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

						{{-- Country --}}
						<div class="mb-3">
							<label class="form-label">Country <span class="text-danger">*</span></label>

							<select name="country"
									class="form-control @error('country') is-invalid @enderror"
									required>

								<option value="">Select Country</option>

								@foreach(config('countries') as $country)
									<option value="{{ $country }}"
										{{ old('country', 'India') == $country ? 'selected' : '' }}>
										{{ $country }}
									</option>
								@endforeach

							</select>

							@error('country')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

                        {{-- Username --}}
                        <div class="mb-3">
                            <label class="form-label">Username (for login) <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                   value="{{ old('username') }}" 
								    oninput="this.value=this.value.toLowerCase()"
       								minlength="4" maxlength="20" required>
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-3">
                            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        {{-- Transaction Password --}}
                        <div class="mb-3">
                            <label class="form-label">Transaction Password <span class="text-danger">*</span></label>
                            <input type="password" name="transaction_password"
 									minlength="6" maxlength="6"
									pattern="[0-9]*"
									inputmode="numeric"
                                   class="form-control @error('transaction_password') is-invalid @enderror"
                                   required>
                            @error('transaction_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm Transaction Password --}}
                        <div class="mb-3">
                            <label class="form-label">Confirm Transaction Password <span class="text-danger">*</span></label>
                            <input type="password" name="transaction_password_confirmation" class="form-control" 
								minlength="6" maxlength="6"
								pattern="[0-9]*"
								inputmode="numeric" required>
                        </div>

                        {{-- Sponsor Code --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Sponsor Code (Referral)
                            </label>
                            <input type="text" name="sponsor_code"
									oninput="this.value=this.value.toUpperCase()"
                                   class="form-control @error('sponsor_code') is-invalid @enderror"
                                   value="{{ request('ref', old('sponsor_code')) }}" required>
                            @error('sponsor_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Position (Left/Right) --}}
                        <div class="mb-3">
                            <label class="form-label">Position under sponsor (if any)</label>
                            <select name="position" class="form-select @error('position') is-invalid @enderror">
                                <option value="">-- Select Position --</option>
                                <option value="left" {{ old('position') == 'left' ? 'selected' : '' }}>Left</option>
                                <option value="right" {{ old('position') == 'right' ? 'selected' : '' }}>Right</option>
                            </select>
                            @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- MT5 Account (optional) --}}
                        <div class="mb-3">
                            <label class="form-label">MT5 Account No (optional)</label>
                            <input type="text" name="mt5_account_no"
                                   class="form-control @error('mt5_account_no') is-invalid @enderror"
                                   value="{{ old('mt5_account_no') }}">
                            @error('mt5_account_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Register
                            </button>
                        </div>

                        <div class="mt-3 text-center">
                            Already have an account?
                            <a href="{{ route('login') }}">Login here</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Bootstrap JS (optional) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
