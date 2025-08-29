@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Users</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('users.index') }}">Users</a></li>
                    </ul>    
                </div>
                
                <div class="right_section">
                    <div class="purple_filled_btn">
                        <a href="{{ route('users.edit', $result->id) }}">Edit</a>
                    </div>
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
                                <div class="title">View User</div>
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
                                    <div class="error form_error form-error-role"></div>
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
                            <input type="text" name="billing_country" placeholder="Country" value="{{ $result->billing_country }}">
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
                            <input type="text" name="shipping_country" placeholder="Country" value="{{ $result->shipping_country }}">
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

            </div>
            </form>
        </div>

    </div>
    <!-- /.row -->

<script type="text/javascript">
$(document).ready(function() {
    $("input").prop('disabled', true);
    $("select").prop('disabled', true);
    $(".delete_icon").css({'display':'none'});
    $(".edit_details").css({'display':'none'});
});
</script>
@endsection    