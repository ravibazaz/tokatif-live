Hi {{ $details['name'] }},

<p>Forgot your password?</p>
<div>
    To reset your password please follow the link below: <br/>
    <a href="{{ $details['url'] }}" target="_blank"> Click here </a>  <br/>

    If you're not sure why you're receiving this message, you can report it to us by emailing support@tokatif.com. <br/><br/>

    If you suspect someone may have unauthorised access to your account, we suggest you change your password as a precaution by visiting  <a href="{{url('/login')}}" target="_blank"> Login </a>  <br/><br/>

    If you need further assistance, please contact our Help team. <br/>

</div>
<br/>

Kind regards, <br/>
Tokatif Team
