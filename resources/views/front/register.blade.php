@extends('front.layout.master')

@section('content')

<div class="register_page single_form_page">
    <div class="overlay_box">

        <div class="form_wrapper">
            <form>
                <div class="col-sm-12">
                    <div class="input_box">
                        <div class="error form_error"></div>
                        <input type="text" name="name" id="name" placeholder="Email">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="input_box">
                        <div class="error form_error"></div>
                        <input type="password" name="email" id="email" placeholder="Full Name">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="input_box">
                        <div class="error form_error"></div>
                        <input type="password" name="email" id="email" placeholder="Company Name">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="input_box">
                        <div class="error form_error"></div>
                        <input type="text" name="name" id="name" placeholder="Username">
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
                    <div class="input_box">
                        <div class="error form_error"></div>
                        
                        <label for="checkbox"><input type="checkbox" id="checkbox"> I accept the Terms of Service and Privacy Policy</label>
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
                        <a href="{{ route('login') }}">Already a member? Login</a>
                    </div>
                </div>
                <div class="clr"></div>
            </form>
        </div>

    </div>

</div>
<!-- careers_page end -->

@endsection