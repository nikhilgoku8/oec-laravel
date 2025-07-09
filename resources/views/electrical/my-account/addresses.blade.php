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
                        <div class="billing_address">
                            <div class="title">Billing address</div>
                            <div class="address">
                                <div class="name">Sameer Parab</div>
                                <div class="mobile">9769830993</div>
                                <div class="email">estore@oec-americas.com</div>
                                <a href="{{ route('my-account.edit-address', 1) }}">Edit Address</a>
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