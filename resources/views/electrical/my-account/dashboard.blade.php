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
                            <p>Hello OEC Ameriaca (not OEC Ameriaca? Log out)</p>
                            <p>From your account dashboard you can view your recent orders, manage your shipping and billing addresses, and edit your password and account details.</p>
                        </div>
                        <div class="nav_links">
                            <div class="link_box">
                                <a href="{{ route('my-account.orders') }}">
                                    <span class="icon_box">
                                        <img src="{{ asset('electrical-assets/images/icons/orders.png') }}">
                                    </span>
                                    <span class="link_title">Orders</span>
                                </a>
                            </div>
                            <div class="link_box">
                                <a href="{{ route('my-account.addresses') }}">
                                    <span class="icon_box">
                                        <img src="{{ asset('electrical-assets/images/icons/addresses.png') }}">
                                    </span>
                                    <span class="link_title">Addresses</span>
                                </a>
                            </div>
                            <div class="link_box">
                                <a href="{{ route('my-account.account-details') }}">
                                    <span class="icon_box">
                                        <img src="{{ asset('electrical-assets/images/icons/account-details.png') }}">
                                    </span>
                                    <span class="link_title">Account details</span>
                                </a>
                            </div>
                            <div class="link_box">
                                <a href="{{ route('my-account.logout') }}">
                                    <span class="icon_box">
                                        <img src="{{ asset('electrical-assets/images/icons/logout.png') }}">
                                    </span>
                                    <span class="link_title">Logout</span>
                                </a>
                            </div>
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