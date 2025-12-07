<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <title>CWG</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
 <body style="background-image: linear-gradient(to left,#33FFCC,#CCFF99)">
 <div class="container" col-lg-8 mt-4>
 	<div class="card pb-5">
		<div class="row">
			{{-- Success message --}}
			@if(session('success'))
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
			@endif

			{{-- General error --}}
			@if($errors->has('general'))
				<div class="alert alert-danger">
					{{ $errors->first('general') }}
				</div>
			@endif

		  <form action="{{ url('register') }}" method="POST">
			@csrf
			<h1 class="text-center mt-3">CWG Registration </h1>						
			<div class="col-10 ms-5 mt-3 ps-3">
				<label>Full Name*</label>
				<input type="text" name="username" value="" placeholder="Enter Your Full Name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
				 @error('name')
					<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>

			<div class="col-10 ms-5 mt-3 ps-3">
				<label>Email*</label>
				<input type="text" name="email" value="" placeholder="Enter Your Email Address" class="form-control" required>
			</div>
			<div class="col-5 ms-5 mt-3 ps-3">
				<label>Mobile Number*</label>
				<input type="text" name="number" placeholder="Enter Your Mobile Number" class="form-control">
			</div>
			<div class="col-5 ms-5 mt-3 ps-3">
				<label>Date Of Birth</label>
				<input type="date" name="dateofbirth" value="" class="form-control">
			</div> 
			<div class="col-5 ms-5 mt-3">
				<label>Gender*</label>
				<select name="gender" class="form-select">					
					<option selected>Male</option>
					<option>Female</option>					
				</select>
			</div>
			<div class="col-5 ms-5 mt-3 ps-3">
				<label>Country*</label>
				<select name="country" id="country" class="form-select">
	<option value="0">Select country--</option>
	<option value="Afghanistan">Afghanistan</option>
	<option value="Albania">Albania</option>
	<option value="Algeria">Algeria</option>
	<option value="Argentina">Argentina</option>
	<option value="Armenia">Armenia</option>
	<option value="Australia">Australia</option>
	<option value="Austria">Austria</option>
	<option value="Azerbaijan">Azerbaijan</option>
	<option value="Bahrain">Bahrain</option>
	<option value="Bangladesh">Bangladesh</option>
	<option value="Belarus">Belarus</option>
	<option value="Belgium">Belgium</option>
	<option value="Belize">Belize</option>
	<option value="Bhutan">Bhutan</option>
	<option value="Bolivia">Bolivia</option>
	<option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
	<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
	<option value="Botswana">Botswana</option>
	<option value="Brazil">Brazil</option>
	<option value="Brunei">Brunei</option>
	<option value="Bulgaria">Bulgaria</option>
	<option value="Cambodia">Cambodia</option>
	<option value="Cameroon">Cameroon</option>
	<option value="Canada">Canada</option>
	<option value="Caribbean">Caribbean</option>
	<option value="Chile">Chile</option>
	<option value="China">China</option>
	<option value="Colombia">Colombia</option>
	<option value="Congo (DRC)">Congo (DRC)</option>
	<option value="Costa Rica">Costa Rica</option>
	<option value="Côte d’Ivoire">Côte d’Ivoire</option>
	<option value="Croatia">Croatia</option>
	<option value="Cuba">Cuba</option>
	<option value="Czechia">Czechia</option>
	<option value="Denmark">Denmark</option>
	<option value="Dominican Republic">Dominican Republic</option>
	<option value="Ecuador">Ecuador</option>
	<option value="Egypt">Egypt</option>
	<option value="El Salvador">El Salvador</option>
	<option value="Eritrea">Eritrea</option>
	<option value="Estonia">Estonia</option>
	<option value="Ethiopia">Ethiopia</option>
	<option value="Faroe Islands">Faroe Islands</option>
	<option value="Finland">Finland</option>
	<option value="France">France</option>
	<option value="Georgia">Georgia</option>
	<option value="Germany">Germany</option>
	<option value="Ghana">Ghana</option>
	<option value="Greece">Greece</option>
	<option value="Greenland">Greenland</option>
	<option value="Guatemala">Guatemala</option>
	<option value="Guyana">Guyana</option>
	<option value="Haiti">Haiti</option>
	<option value="Honduras">Honduras</option>
	<option value="Hong Kong SAR">Hong Kong SAR</option>
	<option value="Hungary">Hungary</option>
	<option value="Iceland">Iceland</option>
	<option value="India">India</option>
	<option value="Indonesia">Indonesia</option>
	<option value="Iran">Iran</option>
	<option value="Iraq">Iraq</option>
	<option value="Ireland">Ireland</option>
	<option value="Israel">Israel</option>
	<option value="Italy">Italy</option>
	<option value="Jamaica">Jamaica</option>
	<option value="Japan">Japan</option>
	<option value="Jordan">Jordan</option>
	<option value="Kazakhstan">Kazakhstan</option>
	<option value="Kenya">Kenya</option>
	<option value="Korea">Korea</option>
	<option value="Kuwait">Kuwait</option>
	<option value="Kyrgyzstan">Kyrgyzstan</option>
	<option value="Laos">Laos</option>
	<option value="Latin America">Latin America</option>
	<option value="Latvia">Latvia</option>
	<option value="Lebanon">Lebanon</option>
	<option value="Liberia ">Liberia </option>
	<option value="Libya">Libya</option>
	<option value="Liechtenstein">Liechtenstein</option>
	<option value="Lithuania">Lithuania</option>
	<option value="Luxembourg">Luxembourg</option>
	<option value="Macao SAR">Macao SAR</option>
	<option value="Malaysia">Malaysia</option>
	<option value="Maldives">Maldives</option>
	<option value="Mali">Mali</option>
	<option value="Malta">Malta</option>
	<option value="Mexico">Mexico</option>
	<option value="Moldova">Moldova</option>
	<option value="Monaco">Monaco</option>
	<option value="Mongolia">Mongolia</option>
	<option value="Montenegro">Montenegro</option>
	<option value="Morocco">Morocco</option>
	<option value="Myanmar">Myanmar</option>
	<option value="Nepal">Nepal</option>
	<option value="Netherlands">Netherlands</option>
	<option value="New Zealand">New Zealand</option>
	<option value="Nicaragua">Nicaragua</option>
	<option value="Nigeria">Nigeria</option>
	<option value="North Macedonia">North Macedonia</option>
	<option value="Norway">Norway</option>
	<option value="Oman">Oman</option>
	<option value="Pakistan">Pakistan</option>
	<option value="Panama">Panama</option>
	<option value="Paraguay">Paraguay</option>
	<option value="Peru">Peru</option>
	<option value="Philippines">Philippines</option>
	<option value="Poland">Poland</option>
	<option value="Portugal">Portugal</option>
	<option value="Puerto Rico">Puerto Rico</option>
	<option value="Qatar">Qatar</option>
	<option value="Réunion">Réunion</option>
	<option value="Romania">Romania</option>
	<option value="Russia">Russia</option>
	<option value="Rwanda">Rwanda</option>
	<option value="Saudi Arabia">Saudi Arabia</option>
	<option value="Senegal">Senegal</option>
	<option value="Serbia">Serbia</option>
	<option value="Singapore">Singapore</option>
	<option value="Slovakia">Slovakia</option>
	<option value="Slovenia">Slovenia</option>
	<option value="Somalia">Somalia</option>
	<option value="South Africa">South Africa</option>
	<option value="Spain">Spain</option>
	<option value="Sri Lanka">Sri Lanka</option>
	<option value="Sweden">Sweden</option>
	<option value="Switzerland">Switzerland</option>
	<option value="Syria">Syria</option>
	<option value="Taiwan">Taiwan</option>
	<option value="Tajikistan">Tajikistan</option>
	<option value="Thailand">Thailand</option>
	<option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
	<option value="Tunisia">Tunisia</option>
	<option value="Türkiye">Türkiye</option>
	<option value="Turkmenistan">Turkmenistan</option>
	<option value="Ukraine">Ukraine</option>
	<option value="United Arab Emirates">United Arab Emirates</option>
	<option value="United Kingdom">United Kingdom</option>
	<option value="United States">United States</option>
	<option value="Uruguay">Uruguay</option>
	<option value="Uzbekistan">Uzbekistan</option>
	<option value="Venezuela">Venezuela</option>
	<option value="Vietnam">Vietnam</option>
	<option value="World">World</option>
	<option value="Yemen">Yemen</option>
	<option value="Zimbabwe">Zimbabwe</option>
</select>
			</div>		
			<div class="col-5 ms-5 mt-3">
				<label>Password*</label>
				<input type="password" name="password_1" value="" placeholder="Enter Your Password" class="form-control" required>
			</div>			
			<div class="col-5 ms-5 mt-3 ps-3">
				<label>Confirm Password*</label>
				<input type="password" name="password_2" placeholder="Enter Your Password" class="form-control" required>
			</div>
			<div class="col-10 ms-5 mt-3 ps-3">
				<label>Referral Code*</label>
				<input type="text" name="referralcode" value="" placeholder="Enter Your Referral Code" class="form-control">
			</div>
			<div class="col-10 ms-5 mt-3">
				<label>Position*</label>
				<select name="position" class="form-select">
					<option selected>Left</option>
					<option>Right</option>
				</select>
			</div>
			<div class="col-10 ms-5 mt-5 ps-3">
				<button type="submit" name="reg_user" class="form-control" style="background-image: linear-gradient(to right,#33FFCC,#CCFF99);">Sign Up</button>
			</div>
			</form>
		</div>
	</div>	
 </div>  

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

 </body>
</html>
 -->

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
                            <label class="form-label">Email (optional)</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Mobile --}}
                        <div class="mb-3">
                            <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror"
                                   value="{{ old('mobile') }}" required>
                            @error('mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Country --}}
                        <div class="mb-3">
                            <label class="form-label">Country <span class="text-danger">*</span></label>
                            <input type="text" name="country" class="form-control @error('country') is-invalid @enderror"
                                   value="{{ old('country', 'India') }}" required>
                            @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Username --}}
                        <div class="mb-3">
                            <label class="form-label">Username (for login) <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                   value="{{ old('username') }}" required>
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
                                   class="form-control @error('transaction_password') is-invalid @enderror"
                                   required>
                            @error('transaction_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm Transaction Password --}}
                        <div class="mb-3">
                            <label class="form-label">Confirm Transaction Password <span class="text-danger">*</span></label>
                            <input type="password" name="transaction_password_confirmation" class="form-control" required>
                        </div>

                        {{-- Sponsor Code --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Sponsor Code (Referral)
                                <small class="text-muted">(optional, if someone referred you)</small>
                            </label>
                            <input type="text" name="sponsor_code"
                                   class="form-control @error('sponsor_code') is-invalid @enderror"
                                   value="{{ old('sponsor_code') }}">
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
