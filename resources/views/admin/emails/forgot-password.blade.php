Hello {{ $details['receiver'] }},
<p>OTP to reset your password.</p>

<div>
    <label>OTP : {{ $details['otp'] }}</label><br />
</div>

Thank You,
<br/>
{{ $details['sender'] }}