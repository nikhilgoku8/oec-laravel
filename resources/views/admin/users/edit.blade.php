@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Edit User</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('users.index') }}">Users</a></li>
                    </ul>    
                </div>
                
                <div class="right_section">
                    <div class="blue_filled_btn">
                        <a href="{{ url()->previous() }}">Back</a>
                    </div>
                </div>
            </div>                    
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">

            <div class="my_panel form_box">
                <form id="data_form" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="dataID" value="{{ $result->id }}">
                <div class="page-header my_style less_margin">
                    <div class="left_section">
                        <div class="title_text">
                            <div class="title">Edit Details</div>
                            <div class="sub_title">Please fillup the form </div>
                        </div>
                    </div>
                    <div class="right_section">
                        <!-- <div class="purple_filled_btn">
                            <a href="#">Save</a>
                        </div> -->
                    </div>
                </div>

                <div class="inner_boxes">

                    <div class="input_boxes">
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>First Name*</label>
                                <div class="error form_error" id="form-error-fname"></div>
                                <input type="text" name="fname" placeholder="First Name" value="{{ $result->fname }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Last Name*</label>
                                <div class="error form_error" id="form-error-lname"></div>
                                <input type="text" name="lname" placeholder="Last Name" value="{{ $result->lname }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Email*</label>
                                <div class="error form_error" id="form-error-email"></div>
                                <input type="text" name="email" placeholder="Email" value="{{ $result->email }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Phone</label>
                                <div class="error form_error" id="form-error-phone"></div>
                                <input type="text" name="phone" placeholder="Phone" value="{{ $result->phone }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Role</label>
                                <div class="error form_error" id="form-error-role"></div>
                                <select name="role">
                                    <option value="">Select Role</option>
                                    <option @selected($result->role == 'Distributor')>Distributor</option>
                                    <option @selected($result->role == 'Contractor')>Contractor</option>
                                    <option @selected($result->role == 'Sales Representative')>Sales Representative</option>
                                    <option @selected($result->role == 'Other')>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Password</label>
                                <div class="error form_error" id="form-error-password"></div>
                                <input type="text" name="password" placeholder="Password">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Confirm Password</label>
                                <div class="error form_error" id="form-error-confirm_password"></div>
                                <input type="text" name="confirm_password" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Is Locked</label>
                                <div class="error form_error" id="form-error-is_locked"></div>
                                <select name="is_locked">
                                    <option value="1" @if(!empty($result->is_locked) && $result->is_locked == 1) selected @endif>Yes</option>
                                    <option value="0" @if($result->is_locked == 0) selected @endif>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Status</label>
                                <div class="error form_error" id="form-error-status"></div>
                                <select name="status">
                                    <option value="pending" @if(!empty($result->status) && $result->status == 'pending') selected @endif>Pending</option>
                                    <option value="approved" @if(!empty($result->status) && $result->status == 'approved') selected @endif>Approved</option>
                                    <option value="denied" @if(!empty($result->status) && $result->status == 'denied') selected @endif>Denied</option>
                                </select>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>

                    <div class="input_boxes">
                        <div class="col-sm-4">
                            <div class="input_box">
                                <input type="submit" name="submit" value="Save" class="btn btn-primary">
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
                </form>
            </div>

    </div>
    <!-- /.row -->

    <div class="row">

        <div class="my_panel form_box">
            <form id="address_update_form" action="" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="dataID" value="{{ $result->id }}">
            <div class="page-header my_style less_margin">
                <div class="left_section">
                    <div class="title_text">
                        <div class="title">Edit Address</div>
                        <div class="sub_title">Please fillup the form </div>
                    </div>
                </div>
                <div class="right_section">
                    <!-- <div class="purple_filled_btn">
                        <a href="#">Save</a>
                    </div> -->
                </div>
            </div>

            <div class="inner_boxes">

                <div class="input_boxes">
                    <div class="col-sm-12">
                        <div class="box_title style1">Billing Details</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input_box">
                            <label>First name <span class="red">*</span></label>
                            <div class="error form_error form-error-billing_fname"></div>
                            <input type="text" name="billing_fname" placeholder="First Name" value="{{ $result->billing_fname ?? $result->fname }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input_box">
                            <label>Last name <span class="red">*</span></label>
                            <div class="error form_error form-error-billing_lname"></div>
                            <input type="text" name="billing_lname" placeholder="Last Name" value="{{ $result->billing_lname ?? $result->lname }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input_box">
                            <label>Email address <span class="red">*</span></label>
                            <div class="error form_error form-error-billing_email"></div>
                            <input type="text" name="billing_email" placeholder="Last Name" value="{{ $result->billing_email ?? $result->email }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input_box">
                            <label>Phone with country code (Optional)</label>
                            <div class="error form_error form-error-billing_phone"></div>
                            <input type="text" name="billing_phone" placeholder="+1987654321" value="{{ $result->billing_phone }}">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="input_box">
                            <label>Company Name</label>
                            <div class="error form_error form-error-billing_company"></div>
                            <input type="text" name="billing_company" placeholder="Company Name" value="{{ $result->billing_company }}">
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="input_box">
                            <label>Address</label>
                            <div class="error form_error form-error-billing_address"></div>
                            <input type="text" name="billing_address" placeholder="Address" value="{{ $result->billing_address }}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_box">
                            <label>City</label>
                            <div class="error form_error form-error-billing_city"></div>
                            <input type="text" name="billing_city" placeholder="City" value="{{ $result->billing_city }}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_box">
                            <label>State</label>
                            <div class="error form_error form-error-billing_state"></div>
                            <input type="text" name="billing_state" placeholder="State" value="{{ $result->billing_state }}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_box">
                            <label>Country</label>
                            <div class="error form_error form-error-billing_country"></div>
                            <!-- <input type="text" name="billing_country" placeholder="Country" value="{{ $result->billing_country }}"> -->
                            <select name="billing_country">
                                @include('countries-dropdown', ['country' => old('country', $result->billing_country ?? '')])
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_box">
                            <label>Postcode</label>
                            <div class="error form_error form-error-billing_postcode"></div>
                            <input type="text" name="billing_postcode" placeholder="Postcode" value="{{ $result->billing_postcode }}">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="input_box">
                            <span class="same_address">
                                <input type="checkbox" name="same_address" id="same_address" placeholder="Same Address*" @if(!empty($result->same_address) && $result->same_address == true) {{'checked'}} @endif>
                                <label for="same_address">Shipping Same as Billing Address</label>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="box_title style1">Shipping address</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input_box">
                            <label>First name <span class="red">*</span></label>
                            <div class="error form_error form-error-shipping_fname"></div>
                            <input type="text" name="shipping_fname" placeholder="First Name" value="{{ $result->shipping_fname ?? $result->fname }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input_box">
                            <label>Last name <span class="red">*</span></label>
                            <div class="error form_error form-error-shipping_lname"></div>
                            <input type="text" name="shipping_lname" placeholder="Last Name" value="{{ $result->shipping_lname ?? $result->lname }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input_box">
                            <label>Email address <span class="red">*</span></label>
                            <div class="error form_error form-error-shipping_email"></div>
                            <input type="text" name="shipping_email" placeholder="Last Name" value="{{ $result->shipping_email ?? $result->email }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input_box">
                            <label>Phone with country code (Optional)</label>
                            <div class="error form_error form-error-shipping_phone"></div>
                            <input type="text" name="shipping_phone" placeholder="+1987654321" value="{{ $result->shipping_phone }}">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="input_box">
                            <label>Company Name</label>
                            <div class="error form_error form-error-shipping_company"></div>
                            <input type="text" name="shipping_company" placeholder="Company Name" value="{{ $result->shipping_company }}">
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="input_box">
                            <label>Address</label>
                            <div class="error form_error form-error-shipping_address"></div>
                            <input type="text" name="shipping_address" placeholder="Address" value="{{ $result->shipping_address }}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_box">
                            <label>City</label>
                            <div class="error form_error form-error-shipping_city"></div>
                            <input type="text" name="shipping_city" placeholder="City" value="{{ $result->shipping_city }}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_box">
                            <label>State</label>
                            <div class="error form_error form-error-shipping_state"></div>
                            <input type="text" name="shipping_state" placeholder="State" value="{{ $result->shipping_state }}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_box">
                            <label>Country</label>
                            <div class="error form_error form-error-shipping_country"></div>
                            <!-- <input type="text" name="shipping_country" placeholder="Country" value="{{ $result->shipping_country }}"> -->
                            <select name="shipping_country">
                                @include('countries-dropdown', ['country' => old('country', $result->shipping_country ?? '')])
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input_box">
                            <label>Postcode</label>
                            <div class="error form_error form-error-shipping_postcode"></div>
                            <input type="text" name="shipping_postcode" placeholder="Postcode" value="{{ $result->shipping_postcode }}">
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
                    <div class="clr"></div>
                </div>

                <div class="input_boxes">
                    <div class="col-sm-4">
                        <div class="input_box">
                            <input type="submit" name="submit" value="Save" class="btn btn-primary">
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
            </form>
        </div>

    </div>
    <!-- /.row -->

<script type="text/javascript">
$(document).ready(function() {

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
        $(`[name=billing_${field}]`).on('change', function () {
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
            $(`[name=shipping_${field}]`).val(billingVal).trigger('change');
        });
    }

    function toggleShippingFields(disable) {
        fields.forEach(function (field) {
            $(`[name=shipping_${field}]`).attr('readonly', disable);
        });
    }

    $("#data_form").on('submit',(function(e){
        e.preventDefault();
        $(".form_error").html("");
        $(".form_error").removeClass("alert alert-danger");

        var formData = new FormData(this);
        formData.append('_method', 'PUT'); // <-- This is important!

        $.ajax({
            type: "POST",
            url: "{{ route('users.update', $result->id) }}",
            data:  formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="{{ route('users.index') }}";
            },
            error: function(data){
                if (data.status === 422) {
                    let errors = data.responseJSON.errors;
                    $.each(errors, function (key, message) {
                        $('#form-error-' + key).html(message).addClass('alert alert-danger');
                    });
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
            }
        });

    }));

    $("#address_update_form").on('submit',(function(e){

        $this = $(this);

        e.preventDefault();
        $this.find(".form_error").html("");
        $this.find(".form_error").removeClass("alert alert-danger");

        $.ajax({
            type: "POST",
            url: "{{ route('users.address_update') }}",
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

});
</script>
            
@endsection    