<p>Dear {{ auth()->user()->name }},</p>
<p>Your wallet transfer was successful.</p>
<p>
    Reference No: <strong>{{ $codeOrRef }}</strong><br>
    Amount: <strong>${{ number_format($amount, 2) }}</strong>
</p>
<p>Thank you.</p>
