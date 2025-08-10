@extends('electrical.layout.master')

@section('content')

<div class="cart_page">
    
<div class="heading">Shopping cart</div>

<div class="products_wrapper">
    <div class="container">
        <div class="inner_container">

            @if (session('success'))
                <div class="col-sm-12">
                    <div class="alert alert-success center title">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(!empty($cartProducts) && count($cartProducts) > 0)
            <form id="update_cart_form" action="" method="POST">
                @csrf
                @if($desktop)
                <table>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Remove</th>
                    </tr>
                    @foreach($cartProducts as $row)
                    <tr>
                        <td><img src="{{ $row->product->productImages[0]->image_file }}" width="80px"></td>
                        <td>
                            <div class="product_title">{{ $row->product->title }}</div>
                            <div class="product_description">{{ Str::limit($row->product->description, 180) }}</div>
                        </td>
                        <td>
                            <div class="error form_error form-error-items-{{$loop->iteration}}-id"></div>
                            <div class="error form_error form-error-items-{{$loop->iteration}}-quantity"></div>
                            <input type="hidden" name="items[{{$loop->iteration}}][id]" value="{{ $row->id }}">
                            <div class="number_input">
                                <button onclick="this.parentNode.querySelector('input').stepDown()" type="button">-</button>
                                <input type="number" name="items[{{$loop->iteration}}][quantity]" value="{{ $row->quantity }}" min="0">
                                <button onclick="this.parentNode.querySelector('input').stepUp()" type="button">+</button>
                            </div>
                        </td>
                        <td>
                            <button class="remove_product" data-cart-item-id="{{$row->id}}"></button>
                        </td>
                    </tr>
                    @endforeach
                </table>
                @else
                    <div class="cart_products_mobile">
                        @foreach($cartProducts as $row)
                            <div class="product_box">
                                <div class="img_box"><img src="{{ $row->product->productImages[0]->image_file }}"></div>
                                <div class="right_info_box">
                                    <div class="product_title">{{ $row->product->title }}</div>
                                    <div class="product_description">{{ Str::limit($row->product->description, 100) }}</div>
                                    <div class="error form_error form-error-items-{{$loop->iteration}}-id"></div>
                                    <div class="error form_error form-error-items-{{$loop->iteration}}-quantity"></div>
                                    <input type="hidden" name="items[{{$loop->iteration}}][id]" value="{{ $row->id }}">
                                    <div class="quantity_wrap">
                                        <span>Quantity</span>
                                        <div class="number_input">
                                            <button onclick="this.parentNode.querySelector('input').stepDown()" type="button">-</button>
                                            <input type="number" name="items[{{$loop->iteration}}][quantity]" value="{{ $row->quantity }}" min="0">
                                            <button onclick="this.parentNode.querySelector('input').stepUp()" type="button">+</button>
                                        </div>
                                    </div>
                                    <button class="remove_product" data-cart-item-id="{{$row->id}}"></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <br>
                <div class="c2a_btns">
                    <button type="submit" class="red_filled_btn">Update Cart</button>
                    <a href="{{ route('cart.clear') }}" class="red_hollow_btn" onclick="return confirm('Are you sure you want to clear the cart?')">Clear Cart</a>
                </div>
            </form>
            <div class="right_pane">
                <div class="checkout_btn_wrapper">
                    <div class="sub_title">Click to next steps</div>
                    <a href="{{ route('checkout') }}" class="red_filled_btn">Request a Quote</a>
                </div>
            </div>
            @else
            <div class="heading center full_width">Your cart is currently empty!</div>
            @endif

        </div>
    </div>
</div>
<!-- products_wrapper end -->

</div>
<!-- products_list_page end -->



<script type="text/javascript">
$(document).ready(function() {

    $("#update_cart_form").on('submit',(function(e){

        $this = $(this);

        e.preventDefault();
        $this.find(".form_error").html("");
        $this.find(".form_error").removeClass("alert alert-danger");

        $.ajax({
            type: "POST",
            url: "{{ route('cart.update') }}",
            data:  new FormData(this),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                window.location.reload();
            },
            error: function(data){
                if (data.status === 422) {
                    let errors = data.responseJSON.errors;
                    let allErrors = '';
                    $.each(errors, function (key, val) {
                        var fieldName = key.replace(/\./g, '-');
                        // $('#form-error-' + key).html(message).addClass('alert alert-danger');
                        allErrors += val + '<br>';
                        $this.find(".form-error-"+fieldName).html(val).addClass('alert alert-danger');
                        // $this.find(".form-error-"+fieldName).addClass('alert alert-danger');
                    });
                    $this.find(".all_errors").html(allErrors).addClass('alert alert-danger');
                } else if (data.status === 401) {
                    alert("Please log in.");
                    // window.location.href = "/login";
                } else if (data.status === 403) {
                    alert("You don’t have permission.");
                } else if (data.status === 404) {
                    alert("The resource was not found.");
                } else if (data.status === 419) {
                    alert("Error - "+419);
                    console.log(data.responseJSON.message);
                } else if (data.status === 500) {
                    alert("Something went wrong on the server.");
                    console.log(data.console_message);
                } else {
                    alert("Unexpected error: " + data.status);
                    console.log(data);
                }
            }
        });

    }));

});
</script>

@endsection