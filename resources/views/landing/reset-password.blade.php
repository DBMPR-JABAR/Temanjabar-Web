@extends('landing.template')
@section('body')

<!-- sign-in -->
<section id="sign-in" class="bglight position-relative padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 rp-0">
                <div class="image login-image h-100">
                    <img src="{{ asset('assets/images/slider/hero01.jpg') }}" alt="" class="w-100 h-100"
                        style="object-fit: cover;">
                </div>
            </div>
            <div class="col-md-6 col-sm-12 whitebox">
                <div class="widget logincontainer">
                    <h3 class="darkcolor bottom35">Reset Password </h3>
                    @if (Session::has('msg'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-{{ Session::get('color') }} alert-dismissible fade show"
                                role="alert">
                                {{ Session::get('msg') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                    <form class="getin_form border-form" action="{{ url('password-reset/'.$user->kode_otp.'/change') }}" method="POST">
                        @csrf
                        <div class="row">
                        <div class="col-md-12 col-sm-12">
                                <div class="form-group bottom35">
                                    <label for="loginPass" class="d-none"></label>
                                    <div class="input-group" id="show_hide_password">
                                        <input name="password" class="form-control" type="password"
                                            placeholder="New Password:" required id="loginPass">
                                        <!-- <div class="input-group-addon" style="border: none;">
                                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group bottom35">
                                    <label for="loginPass" class="d-none"></label>
                                    <div class="input-group" id="show_hide_password">
                                        <input name="password_confirmation" class="form-control" type="password"
                                            placeholder="Confirm Password:" required id="loginPass">
                                        <div class="input-group-addon" style="border: none;">
                                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('password')
                            <div class="col-md-12 col-sm-12">
                                <span role="alert" style="font-size:12px;color: red">
                                    <strong>{{$message}}</strong>
                                </span>
                            </div>
                            @enderror
                            <div class="col-sm-12">
                                <button type="submit" class="button gradient-btn btnprimary">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- sign-in ends -->

@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
    $("#show_hide_password1 a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password1 input').attr("type") == "text"){
            $('#show_hide_password1 input').attr('type', 'password');
            $('#show_hide_password1 i').addClass( "fa-eye-slash" );
            $('#show_hide_password1 i').removeClass( "fa-eye" );
        }else if($('#show_hide_password1 input').attr("type") == "password"){
            $('#show_hide_password1 input').attr('type', 'text');
            $('#show_hide_password1 i').removeClass( "fa-eye-slash" );
            $('#show_hide_password1 i').addClass( "fa-eye" );
        }
    });
});
</script>
@endsection
