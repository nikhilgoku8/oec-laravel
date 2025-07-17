@extends('electrical.layout.master')

@section('content')

<div class="my_account_page dashboard">

<div class="section_one">
    <div class="container">
        <div class="inner_container">
            
            <div class="heading">My Account</div>

            <div class="info_wrapper">
                <div class="left_pane">
                    <div class="account_links">
                        <!-- <div class="title">My Account</div> -->
                        @include('electrical.my-account.account-links')
                    </div>
                    <div class="you_may_like">
                        <div class="title">You May Also Like…</div>
                        @include('electrical.my-account.you-may-like')
                    </div>
                </div>
                <div class="right_pane">
                    <div class="inner_box">
                        <div class="form_wrapper">
                            <form id="account_details_form" action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="col-sm-12">
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <div class="input_box">
                                        <label>First name <span class="red">*</span></label>
                                        <div class="error form_error form-error-fname"></div>
                                        <input type="text" name="fname" placeholder="First Name" value="{{ $user->fname }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input_box">
                                        <label>Last name <span class="red">*</span></label>
                                        <div class="error form_error form-error-lname"></div>
                                        <input type="text" name="lname" placeholder="Last Name" value="{{ $user->lname }}">
                                    </div>
                                </div>
                                <!-- <div class="col-sm-12">
                                    <div class="input_box">
                                        <label>Display name <span class="red">*</span></label>
                                        <div class="error form_error"></div>
                                        <input type="text" name="" placeholder="Display name">
                                        <div class="note">This will be how your name will be displayed in the account section and in reviews</div>
                                    </div>
                                </div> -->
                                <div class="col-sm-12">
                                    <div class="input_box">
                                        <label>Email address <span class="red">*</span></label>
                                        <div class="error form_error"></div>
                                        <input type="text" name="" value="estore@oec-americas.com" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    @if (session('password_changed'))
                                        <div class="alert alert-success">
                                            {{ session('password_changed') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-12">
                                    <fieldset>
                                        <legend>Password change</legend>
                                        <div class="col-sm-12">
                                            <div class="input_box">
                                                <label>Current password (leave blank to leave unchanged)</label>
                                                <div class="error form_error form-error-current_password"></div>
                                                <div class="password_wrapper">
                                                    <input type="password" name="current_password" placeholder="Current Password">
                                                    <button type="button" class="eye">
                                                        <span class="eye_open">
                                                            <i class="far fa-eye"></i>
                                                        </span>
                                                        <span class="eye_closed">
                                                            <i class="far fa-eye-slash"></i>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="input_box">
                                                <label>New password (leave blank to leave unchanged)</label>
                                                <div class="error form_error form-error-new_password"></div>
                                                <div class="password_wrapper">
                                                    <input type="password" name="new_password" placeholder="New Password">
                                                    <button type="button" class="eye">
                                                        <span class="eye_open">
                                                            <i class="far fa-eye"></i>
                                                        </span>
                                                        <span class="eye_closed">
                                                            <i class="far fa-eye-slash"></i>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="input_box">
                                                <label>Confirm new password</label>
                                                <div class="error form_error form-error-confirm_new_password"></div>
                                                <div class="password_wrapper">
                                                    <input type="password" name="confirm_new_password" placeholder="Confirm New Password">
                                                    <button type="button" class="eye">
                                                        <span class="eye_open">
                                                            <i class="far fa-eye"></i>
                                                        </span>
                                                        <span class="eye_closed">
                                                            <i class="far fa-eye-slash"></i>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-sm-12">
                                    <div class="submit_box">
                                        <button class="red_filled_btn">Save Changes</button>
                                    </div>
                                </div>
                                <div class="clr"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- section_one end -->

</div>
<!-- operation_manual_page end -->

<script>
$(document).ready(function () {

    $('.eye').on('click', function(){
        $(this).toggleClass('show_password');
        const input = $(this).prev();
        input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
    });

    $("#account_details_form").on('submit',(function(e){

        $this = $(this);

        e.preventDefault();
        $this.find(".form_error").html("");
        $this.find(".form_error").removeClass("alert alert-danger");

        $.ajax({
            type: "POST",
            url: "{{ route('account-details.post') }}",
            data:  new FormData(this),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                window.location.reload();
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