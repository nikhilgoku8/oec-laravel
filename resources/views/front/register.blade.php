@extends('front.layout.master')

@section('content')

<div class="register_page single_form_page">
    <div class="overlay_box">

        <div class="form_wrapper">
            <form id="register_form" action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-sm-12">
                    <div class="title red center">Register</div>
                </div>
                <div class="col-sm-6">
                    <div class="input_box">
                        <div class="error form_error form-error-fname"></div>
                        <input type="text" name="fname" placeholder="First Name">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="input_box">
                        <div class="error form_error form-error-lname"></div>
                        <input type="text" name="lname" placeholder="Last Name">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="input_box">
                        <div class="error form_error form-error-company_name"></div>
                        <input type="text" name="company_name" placeholder="Company Name">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="input_box">
                        <div class="error form_error form-error-email"></div>
                        <input type="text" name="email" placeholder="Email">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="input_box">
                        <div class="error form_error form-error-otp"></div>
                        <input type="text" name="otp" placeholder="OTP">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="input_box">
                        <div class="error form_error form-error-request_otp"></div>
                        <button type="button" class="red_hollow_btn full_width square request_otp">Request OTP</button>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="input_box">
                        <div class="error form_error form-error-password"></div>
                        <input type="password" name="password" placeholder="Password">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="input_box">
                        <div class="error form_error form-error-confirm_password"></div>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="input_box">
                        <div class="error form_error form-error-accept_terms"></div>
                        <label for="checkbox"><input type="checkbox" id="checkbox" name="accept_terms"> I accept the Terms of Service and Privacy Policy</label>
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


<script type="text/javascript">
$(document).ready(function() {

    $(".request_otp").on('click',(function(e){

        var button = $(this);
        button.attr('disabled', 'disabled');
        button.addClass('spinners');

        $this = $(this).closest('form');
        let _token = $('[name=_token]').val();
        let email = $this.find('[name=email]').val();
        // alert(email);
        // $this = $(this);
        let formData = new FormData()
        formData.append('_token', _token);
        formData.append('email', email);

        e.preventDefault();
        $this.find(".form_error").html("");
        $this.find(".form_error").removeClass("alert alert-danger");

        $.ajax({
            type: "POST",
            url: "{{ route('sendOtpViaEmail') }}",
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                button.removeClass('spinners');
                $this.find(".form-error-request_otp").html('OTP Sent On Email');

                // Countdown start
                var countdown = 120;

                // Update button text and countdown every second
                var countdownInterval = setInterval(function() {
                    button.text(countdown + 's');
                    countdown--;

                    // When countdown reaches 0, enable the button again and reset text
                    if (countdown < 0) {
                        clearInterval(countdownInterval);
                        button.prop('disabled', false).text('Resend OTP');
                    }
                }, 1000); // Run every 1000ms (1 second)

            },
            error: function(data){
                if (data.status === 422) {
                    let errors = data.responseJSON.errors;
                    let allErrors = '';
                    $.each(errors, function (key, val) {
                        var fieldName = key.replace(/\./g, '-');
                        // $('#form-error-' + key).html(message).addClass('alert alert-danger');
                        allErrors += val + '<br>';
                        $this.find(".form-error-"+fieldName).html(val).addClass('alert alert-danger');
                        // $this.find(".form-error-"+fieldName).addClass('alert alert-danger');
                    });
                    $this.find(".all_errors").html(allErrors).addClass('alert alert-danger');
                } else if (data.status === 419) {
                    alert("Error - "+419);
                    console.log(data.responseJSON.message);
                } else if (data.status === 401) {
                    alert("Please log in.");
                    // window.location.href = "/login";
                } else if (data.status === 403) {
                    alert("You don’t have permission.");
                } else if (data.status === 404) {
                    alert("The resource was not found.");
                } else if (data.status === 500) {
                    alert("Something went wrong on the server.");
                    console.log(data.console_message);
                } else {
                    alert("Unexpected error: " + data.status);
                    console.log(data);
                }

                button.prop('disabled', false).removeClass('spinners');
            }
        });

    }));

    $("#register_form").on('submit',(function(e){

        $this = $(this);

        e.preventDefault();
        $this.find(".form_error").html("");
        $this.find(".form_error").removeClass("alert alert-danger");

        $.ajax({
            type: "POST",
            url: "{{ route('register.post') }}",
            data:  new FormData(this),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="{{ route('login') }}";
            },
            // error: function(data){
            //     var responseData = data.responseJSON;
            //     if(responseData.error_type=='form'){
            //         jQuery.each( responseData.errors, function( i, val ) {
            //             $("#form-error-"+i).html(val);
            //             $("#form-error-"+i).addClass('alert alert-danger');
            //         });
            //     }else{
            //         alert(responseData.message || 'An unexpected error occurred.');
            //         console.log(responseData.console_message);
            //     }
            // }
            error: function(data){
                if (data.status === 422) {
                    let errors = data.responseJSON.errors;
                    let allErrors = '';
                    $.each(errors, function (key, val) {
                        var fieldName = key.replace(/\./g, '-');
                        // $('#form-error-' + key).html(message).addClass('alert alert-danger');
                        allErrors += val + '<br>';
                        $this.find(".form-error-"+fieldName).html(val).addClass('alert alert-danger');
                        // $this.find(".form-error-"+fieldName).addClass('alert alert-danger');
                    });
                    $this.find(".all_errors").html(allErrors).addClass('alert alert-danger');
                } else if (data.status === 401) {
                    alert("Please log in.");
                    // window.location.href = "/login";
                } else if (data.status === 403) {
                    alert("You don’t have permission.");
                } else if (data.status === 404) {
                    alert("The resource was not found.");
                } else if (data.status === 419) {
                    alert("Error - "+419);
                    console.log(data.responseJSON.message);
                } else if (data.status === 500) {
                    alert("Something went wrong on the server.");
                    console.log(data.console_message);
                } else {
                    alert("Unexpected error: " + data.status);
                    console.log(data);
                }
            }
        });

    }));

});
</script>

@endsection