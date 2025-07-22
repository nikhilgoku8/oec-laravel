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
                        
                        <table>
                            <tr>
                                <th>Order</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                            @if(!empty($user->orders) && count($user->orders) > 0)
                                @foreach($user->orders as $order)
                                <tr>
                                    <td><a href="{{ route('my-account.view-order', $order->order_ref_id) }}">#{{$order->order_ref_id}}</a></td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ ucwords($order->status) }}</td>
                                    <td>for {{count($order->orderProducts)}} item</td>
                                    <td><a class="red_filled_btn" href="{{ route('my-account.view-order', $order->order_ref_id) }}">View</a></td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="5">No Orders</td>
                            </tr>
                            @endif
                        </table>

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