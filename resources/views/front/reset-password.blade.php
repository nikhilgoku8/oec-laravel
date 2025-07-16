@extends('front.layout.master')

@section('content')

<div class="login_page single_form_page">
    <div class="overlay_box">

        <div class="form_wrapper">
            <form>
                <div class="col-sm-12">
                    <div class="input_box">
                        <div class="error form_error"></div>
                        <input type="text" name="name" id="name" placeholder="Username / Email">
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="input_box">
                        <div class="error form_error"></div>
                        <input type="text" name="OTP" id="OTP" placeholder="OTP">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="input_box">
                        <div class="error form_error"></div>
                        <button>Request OTP</button>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="input_box">
                        <div class="error form_error"></div>
                        <input type="password" name="email" id="email" placeholder="Password">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="input_box">
                        <div class="error form_error"></div>
                        <input type="password" name="email" id="email" placeholder="Confirm Password">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="submit_box">
                        <div class="error form_error all_errors"></div>
                        <button type="submit" class="red_filled_btn full_width square">Sign In</button>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="other_text">
                        <a href="{{ route('register') }}">Don't have an account? Signup now</a>
                    </div>
                </div>
                <div class="clr"></div>
            </form>
        </div>

    </div>

</div>
<!-- careers_page end -->

@endsection