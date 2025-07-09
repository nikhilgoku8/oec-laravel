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
                            @for($i=1; $i<=5; $i++)
                            <tr>
                                <td><a href="{{ route('my-account.view-order', '9300'.$i) }}">#9300{{$i}}</a></td>
                                <td>{{ now() }}</td>
                                <td>Processing</td>
                                <td>for 1 item</td>
                                <td><a class="red_filled_btn" href="{{ route('my-account.view-order', '9300'.$i) }}">View</a></td>
                            </tr>
                            @endfor
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