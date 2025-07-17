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
                            <form id="account_details_form" action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="col-sm-12">
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-12">
                                    <div class="title">Billing address</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input_box">
                                        <label>First name <span class="red">*</span></label>
                                        <div class="error form_error form-error-billing_first_name"></div>
                                        <input type="text" name="billing_first_name" placeholder="First Name" value="{{ $user->billing_first_name ?? $user->fname }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input_box">
                                        <label>Last name <span class="red">*</span></label>
                                        <div class="error form_error form-error-billing_last_name"></div>
                                        <input type="text" name="billing_last_name" placeholder="Last Name" value="{{ $user->billing_last_name ?? $user->lname }}">
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

@endsection