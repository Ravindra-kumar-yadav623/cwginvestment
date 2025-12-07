<p>Dear {{ auth()->user()->name }},</p>
<p>Your OTP for wallet transfer is: <strong>{{ $codeOrRef }}</strong></p>
<p>This OTP will expire in 10 minutes.</p>
