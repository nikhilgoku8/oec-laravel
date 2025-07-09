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
                            <p>Order #<b class="imp_txt">93007</b> was placed on <b class="imp_txt">March 31, 2025</b> and is currently <b class="imp_txt">Processing</b>.</p>
                        </div>
                        <div class="order_details_wrapper">
                            <div class="title">Order details</div>
                            <table class="order_details">
                                <tr>
                                    <th>Product(s)</th>
                                </tr>
                                <tr>
                                    <td>
                                        <div>98001</div>
                                        <div>OEC 98001, 8 AWG, #10 Stud, Copper, One Hole Standard Barrel Compression Lug, with Inspection…</div>
                                        <div>× 1</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>98001</div>
                                        <div>OEC 98001, 8 AWG, #10 Stud, Copper, One Hole Standard Barrel Compression Lug, with Inspection…</div>
                                        <div>× 1</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>98001</div>
                                        <div>OEC 98001, 8 AWG, #10 Stud, Copper, One Hole Standard Barrel Compression Lug, with Inspection…</div>
                                        <div>× 1</div>
                                    </td>
                                </tr>
                            </table>
                            <div class="billing_address">
                                <div class="title">Billing address</div>
                                <div class="address">
                                    <div class="name">Sameer Parab</div>
                                    <div class="mobile">9769830993</div>
                                    <div class="email">estore@oec-americas.com</div>
                                </div>
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