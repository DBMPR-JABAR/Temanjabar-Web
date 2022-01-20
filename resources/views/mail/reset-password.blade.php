<h3>Temanjabar Password Reset</h3>
<p>
Halo <strong>{{ $name }}</strong>,
</p>
<p>We heard that you lost your Temanjabar password. Sorry about that!</p>
<p>But don't worry! you can use the following button to reset your password</p>
<p>
    <a href="{{url('password-reset/'.$code)}}">
        <button>
            Reset your password
        </button>    
    </a>
</p>
<!-- <p>this link will expire soon. To get a new password link, visit: </p>
<a href="{{url('password-reset')}}">
    {{url('password-reset')}}
</a> -->
<p style="font-side:10px; color:red">If you did not initiate this change, please contact your administrator immediately</p>
<p>Thaks,</p>
<p>The Temanjabar Team,</p>