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
                        <div class="text_box">
                            <p>The following addresses will be used on the checkout page by default.</p>
                            <!-- <div class="title">Billing address</div> -->
                        </div>
                        <div class="form_wrapper">
                            <form id="address_update_form" action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="col-sm-12">
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-success">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-12">
                                    <div class="title">Billing address</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input_box">
                                        <label>First name <span class="red">*</span></label>
                                        <div class="error form_error form-error-billing_fname"></div>
                                        <input type="text" name="billing_fname" placeholder="First Name" value="{{ $user->billing_fname ?? $user->fname }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input_box">
                                        <label>Last name <span class="red">*</span></label>
                                        <div class="error form_error form-error-billing_lname"></div>
                                        <input type="text" name="billing_lname" placeholder="Last Name" value="{{ $user->billing_lname ?? $user->lname }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input_box">
                                        <label>Email address <span class="red">*</span></label>
                                        <div class="error form_error form-error-billing_email"></div>
                                        <input type="text" name="billing_email" placeholder="Last Name" value="{{ $user->billing_email ?? $user->email }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input_box">
                                        <label>Phone with country code (Optional)</label>
                                        <div class="error form_error form-error-billing_phone"></div>
                                        <input type="text" name="billing_phone" placeholder="+1987654321" value="{{ $user->billing_phone }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input_box">
                                        <label>Company Name</label>
                                        <div class="error form_error form-error-billing_company"></div>
                                        <input type="text" name="billing_company" placeholder="Company Name" value="{{ $user->billing_company }}">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="input_box">
                                        <label>Address</label>
                                        <div class="error form_error form-error-billing_address"></div>
                                        <input type="text" name="billing_address" placeholder="Address" value="{{ $user->billing_address }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input_box">
                                        <label>City</label>
                                        <div class="error form_error form-error-billing_city"></div>
                                        <input type="text" name="billing_city" placeholder="City" value="{{ $user->billing_city }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input_box">
                                        <label>State</label>
                                        <div class="error form_error form-error-billing_state"></div>
                                        <input type="text" name="billing_state" placeholder="State" value="{{ $user->billing_state }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input_box">
                                        <label>Country</label>
                                        <div class="error form_error form-error-billing_country"></div>
                                        <input type="text" name="billing_country" placeholder="Country" value="{{ $user->billing_country }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input_box">
                                        <label>Postcode</label>
                                        <div class="error form_error form-error-billing_postcode"></div>
                                        <input type="text" name="billing_postcode" placeholder="Postcode" value="{{ $user->billing_postcode }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input_box">
                                        <span class="same_address">
                                            <input type="checkbox" name="same_address" id="same_address" placeholder="Same Address*" @if(!empty($user->same_address) && $user->same_address == true) {{'checked'}} @endif>
                                            <label for="same_address">Same as Billing Address</label>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="title">Shipping address</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input_box">
                                        <label>First name <span class="red">*</span></label>
                                        <div class="error form_error form-error-shipping_fname"></div>
                                        <input type="text" name="shipping_fname" placeholder="First Name" value="{{ $user->shipping_fname ?? $user->fname }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input_box">
                                        <label>Last name <span class="red">*</span></label>
                                        <div class="error form_error form-error-shipping_lname"></div>
                                        <input type="text" name="shipping_lname" placeholder="Last Name" value="{{ $user->shipping_lname ?? $user->lname }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input_box">
                                        <label>Email address <span class="red">*</span></label>
                                        <div class="error form_error form-error-shipping_email"></div>
                                        <input type="text" name="shipping_email" placeholder="Last Name" value="{{ $user->shipping_email ?? $user->email }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input_box">
                                        <label>Phone with country code (Optional)</label>
                                        <div class="error form_error form-error-shipping_phone"></div>
                                        <input type="text" name="shipping_phone" placeholder="+1987654321" value="{{ $user->shipping_phone }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input_box">
                                        <label>Company Name</label>
                                        <div class="error form_error form-error-shipping_company"></div>
                                        <input type="text" name="shipping_company" placeholder="Company Name" value="{{ $user->shipping_company }}">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="input_box">
                                        <label>Address</label>
                                        <div class="error form_error form-error-shipping_address"></div>
                                        <input type="text" name="shipping_address" placeholder="Address" value="{{ $user->shipping_address }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input_box">
                                        <label>City</label>
                                        <div class="error form_error form-error-shipping_city"></div>
                                        <input type="text" name="shipping_city" placeholder="City" value="{{ $user->shipping_city }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input_box">
                                        <label>State</label>
                                        <div class="error form_error form-error-shipping_state"></div>
                                        <input type="text" name="shipping_state" placeholder="State" value="{{ $user->shipping_state }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input_box">
                                        <label>Country</label>
                                        <div class="error form_error form-error-shipping_country"></div>
                                        <input type="text" name="shipping_country" placeholder="Country" value="{{ $user->shipping_country }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input_box">
                                        <label>Postcode</label>
                                        <div class="error form_error form-error-shipping_postcode"></div>
                                        <input type="text" name="shipping_postcode" placeholder="Postcode" value="{{ $user->shipping_postcode }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-success">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-12">
                                    <div class="submit_box">
                                        <div class="error form_error all_errors"></div>
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
    
$(document).ready(function(){

    $("#address_update_form").on('submit',(function(e){

        $this = $(this);

        e.preventDefault();
        $this.find(".form_error").html("");
        $this.find(".form_error").removeClass("alert alert-danger");

        $.ajax({
            type: "POST",
            url: "{{ route('my-account.addresses.post') }}",
            data:  new FormData(this),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                // location.href="{{ route('login') }}";
                window.location.reload();
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

    const fields = ['fname', 'lname', 'phone', 'email', 'company', 'address', 'city', 'state', 'country', 'postcode'];

    $('#same_address').on('change', function () {
        if ($(this).is(':checked')) {
            updateShippingAddress();
            toggleShippingFields(true);
        } else {
            toggleShippingFields(false);
        }
    });

    if ($('#same_address').is(':checked')) {
        updateShippingAddress();
        toggleShippingFields(true);
    } else {
        toggleShippingFields(false);
    }

    // Attach input event to billing fields
    fields.forEach(function (field) {
        // $(`#billing_${field}`).on('input', function () {
        $(`[name=billing_${field}]`).on('input', function () {
            if ($('#same_address').is(':checked')) {
                setTimeout(updateShippingAddress, 100);
            }
        });
    });

    // function updateShippingAddress() {
    //     fields.forEach(function (field) {
    //         const billingVal = $(`#billing_${field}`).val();
    //         $(`#shipping_${field}`).val(billingVal);
    //     });
    // }

    // function toggleShippingFields(disable) {
    //     fields.forEach(function (field) {
    //         $(`#shipping_${field}`).attr('readonly', disable);
    //     });
    // }

    function updateShippingAddress() {
        fields.forEach(function (field) {
            const billingVal = $(`[name=billing_${field}]`).val();
            $(`[name=shipping_${field}]`).val(billingVal);
        });
    }

    function toggleShippingFields(disable) {
        fields.forEach(function (field) {
            $(`[name=shipping_${field}]`).attr('readonly', disable);
        });
    }

});

</script>

@endsection