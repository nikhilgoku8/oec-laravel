@extends('electrical.layout.master')

@section('content')

<div class="my_account_page view_order_page">

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
                            <p>Order #<b class="imp_txt">{{ $order->order_ref_id }}</b> was placed on <b class="imp_txt">{{ \Carbon\Carbon::parse($order->order_ref_id)->format('F d, Y') }}</b> and is currently <b class="imp_txt">{{ ucwords($order->status) }}</b>.</p>
                            @if(!empty($order->admin_remark))
                                <p>Admin Remark : {{ $order->admin_remark }}</p>
                            @endif
                        </div>
                        <div class="order_details_wrapper">
                            <div class="title">Order details</div>
                            <table class="order_details">
                                <tr>
                                    <th>Product(s)</th>
                                </tr>
                                @foreach($order->orderProducts as $row)
                                <tr>
                                    <td>
                                        <div class="product_title">{{ $row->product->title }}</div>
                                        <div class="product_description">{{ $row->product->description }}</div>
                                        <div class="product_quantity">× {{ $row->quantity }}</div>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            <div class="billing_address">
                                <div class="title">Billing address</div>
                                <div class="address">
                                    <div class="name">{{ $order->billing_fname .' '. $order->billing_lname }}</div>
                                    <div class="mobile">{{ $order->billing_phone }}</div>
                                    <div class="email">{{ $order->billing_email }}</div>
                                    <br>
                                    <div class="address">{{ $order->billing_address .' '. $order->billing_city .' '. $order->billing_state .' '. $order->billing_country .' '. $order->billing_postcode }}</div>
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