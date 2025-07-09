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
                                        <label>Display name <span class="red">*</span></label>
                                        <div class="error form_error"></div>
                                        <input type="text" name="" placeholder="Display name">
                                        <div class="note">This will be how your name will be displayed in the account section and in reviews</div>
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
                                    <fieldset>
                                        <legend>Password change</legend>
                                        <div class="col-sm-12">
                                            <div class="input_box">
                                                <label>Current password (leave blank to leave unchanged)</label>
                                                <div class="error form_error"></div>
                                                <div class="password_wrapper">
                                                    <input type="text" name="">
                                                    <button type="button" class="eye">
                                                        <span class="eye_open">
                                                            <i class="far fa-eye"></i>
                                                        </span>
                                                        <!-- <span class="eye_closed">
                                                            <i class="far fa-eye-slash"></i>
                                                        </span> -->
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="input_box">
                                                <label>New password (leave blank to leave unchanged)</label>
                                                <div class="error form_error"></div>
                                                <div class="password_wrapper">
                                                    <input type="text" name="">
                                                    <button type="button" class="eye">
                                                        <span class="eye_open">
                                                            <i class="far fa-eye"></i>
                                                        </span>
                                                        <!-- <span class="eye_closed">
                                                            <i class="far fa-eye-slash"></i>
                                                        </span> -->
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="input_box">
                                                <label>Confirm new password</label>
                                                <div class="error form_error"></div>
                                                <div class="password_wrapper">
                                                    <input type="text" name="">
                                                    <button type="button" class="eye">
                                                        <span class="eye_open">
                                                            <i class="far fa-eye"></i>
                                                        </span>
                                                        <!-- <span class="eye_closed">
                                                            <i class="far fa-eye-slash"></i>
                                                        </span> -->
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

@endsection