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
                            <div class="title">Billing address</div>
                        </div>
                        <div class="form_wrapper">
                            <form>
                                <div class="col-sm-6">
                                    <div class="input_box">
                                        <label>First name <span class="red">*</span></label>
                                        <div class="error form_error"></div>
                                        <input type="text" name="" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input_box">
                                        <label>Last name <span class="red">*</span></label>
                                        <div class="error form_error"></div>
                                        <input type="text" name="" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input_box">
                                        <label>Country / Region <span class="red">*</span></label>
                                        <div class="error form_error"></div>
                                        <!-- <input type="text" name="" placeholder="India"> -->
                                        <select name="billing_country">
                                            @include('countries-dropdown', ['country' => old('country', $user->billing_country ?? '')])
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input_box">
                                        <label>Street address <span class="red">*</span></label>
                                        <div class="error form_error"></div>
                                        <input type="text" name="" placeholder="House number and street name">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input_box">
                                        <div class="error form_error"></div>
                                        <input type="text" name="" placeholder="Apartment, suite, unit, etc. (optional)">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input_box">
                                        <label>Town / City <span class="red">*</span></label>
                                        <div class="error form_error"></div>
                                        <input type="text" name="" placeholder="House number and street name">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input_box">
                                        <label>State <span class="red">*</span></label>
                                        <div class="error form_error"></div>
                                        <input type="text" name="" placeholder="House number and street name">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input_box">
                                        <label>ZIP Code <span class="red">*</span></label>
                                        <div class="error form_error"></div>
                                        <input type="text" name="" placeholder="House number and street name">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input_box">
                                        <label>Phone (optional)</label>
                                        <div class="error form_error"></div>
                                        <input type="text" name="" placeholder="9769830993">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="input_box">
                                        <label>Email address <span class="red">*</span></label>
                                        <div class="error form_error"></div>
                                        <input type="text" name="" value="estore@oec-americas.com">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="submit_box">
                                        <button class="red_filled_btn">Save Address</button>
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