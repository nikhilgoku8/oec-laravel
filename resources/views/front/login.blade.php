@extends('front.layout.master')

@section('content')

<div class="login_page single_form_page">
    <div class="overlay_box">

        <div class="form_wrapper">
            <form id="login_form" action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-sm-12">
                    <div class="title red center">Login</div>
                </div>
                <div class="col-sm-12">
                    <div class="input_box">
                        <div class="error form_error form-error-email"></div>
                        <input type="text" name="email" placeholder="Email">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="input_box">
                        <div class="error form_error form-error-password"></div>
                        <input type="password" name="password" placeholder="Password">
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
                    <div class="other_text">
                        <a href="{{ route('reset-password') }}">Forgot Password? Reset Password</a>
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

    $("#login_form").on('submit',(function(e){

        $this = $(this);

        e.preventDefault();
        $this.find(".form_error").html("");
        $this.find(".form_error").removeClass("alert alert-danger");

        var button = $(this).find('[type=submit]');
        button.attr('disabled', 'disabled');
        button.addClass('spinners');

        $.ajax({
            type: "POST",
            url: "{{ route('authenticateUser') }}",
            data:  new FormData(this),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="{{ route('electrical') }}";
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
                        $this.find(".form-error-"+fieldName).addClass('alert alert-danger');
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

                button.prop('disabled', false).removeClass('spinners');
            }
        });

    }));

});
</script>
@endsection