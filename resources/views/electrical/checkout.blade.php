@extends('electrical.layout.master')

@section('content')

<div class="checkout_page">
    
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
            <div class="col-sm-6">
                <div class="form_wrapper">
                    <form id="checkout_form" action="" method="POST">
                        @csrf
                        <div class="col-sm-12">
                            <div class="sub_title">Billing details</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">First Name <span class="red">*</span></label>
                                <div class="error form_error form-error-billing_fname"></div>
                                <input type="text" name="billing_fname" placeholder="First Name" value="{{ $user->billing_fname ?? $user->fname }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label for="name">Last Name <span class="red">*</span></label>
                                <div class="error form_error form-error-billing_lname"></div>
                                <input type="text" name="billing_lname" placeholder="Last Name" value="{{ $user->billing_lname ?? $user->lname }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label for="name">Email <span class="red">*</span></label>
                                <div class="error form_error form-error-billing_email"></div>
                                <input type="text" name="billing_email" placeholder="Email" value="{{ $user->billing_email ?? $user->email }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label for="name">Phone (optional)</label>
                                <div class="error form_error form-error-billing_phone"></div>
                                <input type="text" name="billing_phone" placeholder="Phone" value="{{ $user->billing_phone }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label for="name">Country <span class="red">*</span></label>
                                <div class="error form_error form-error-billing_country"></div>
                                <select name="billing_country">
                                    @include('countries-dropdown', ['country' => old('country', $user->billing_country ?? '')])
                                </select>
                                <!-- <input type="text" name="billing_country" placeholder="Country" value="{{ $user->billing_country }}"> -->
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="sub_title">Additional information</div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label for="name">Enquiry Notes (optional)</label>
                                <div class="error form_error form-error-enquiry_notes"></div>
                                <textarea name="enquiry_notes" placeholder="Enquiry Notes"></textarea>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="enquiry_product_list">
                    <div class="sub_title">Enquiry List</div>
                    <div class="products_wrapper">
                        @foreach($cartProducts as $row)
                            <div class="product_box">
                                <a href="{{ route('product', [
                                    'category' => $row->product->subCategory->category->slug,
                                    'subCategory' => $row->product->subCategory->slug,
                                    'product' => $row->product->slug
                                ]) }}">
                                    <div class="img_box">
                                        <img src="{{ $row->product->productImages[0]->image_file }}">
                                    </div>
                                    <div class="text_box">
                                        <div class="product_title">{{ $row->product->title }}</div>
                                        <div class="product_description">{{ Str::limit($row->product->description, 75) }}</div>
                                        <div class="product_count">
                                            <span class="number">{{ $row->quantity }}</span>
                                            <span class="times">x</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="info_text">
                        <p>Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="{{ route('privacy-policy') }}">privacy policy</a>.</p>
                    </div>
                </div>
                <div class="error form_error form-error-all_errors"></div>
                <button type="submit" class="red_filled_btn" form="checkout_form">Submit</button>
            </div>
            <div class="clr"></div>
            @else
            <div class="heading">Your cart is currently empty!</div>
                    <!-- <br>
                    <div class="c2a_btns">
                        <button type="submit" class="red_filled_btn">Update Cart</button>
                        <a href="{{ route('cart.clear') }}" class="red_hollow_btn" onclick="return confirm('Are you sure you want to clear the cart?')">Clear Cart</a>
                    </div> -->
            @endif

        </div>
    </div>
</div>
<!-- products_wrapper end -->

</div>
<!-- products_list_page end -->



<script type="text/javascript">
$(document).ready(function() {

    $("#checkout_form").on('submit',(function(e){

        $this = $(this);

        e.preventDefault();
        $this.find(".form_error").html("");
        $this.find(".form_error").removeClass("alert alert-danger");
        
        $this.find(".form-error-all_errors").html("");
        $this.find(".form-error-all_errors").removeClass("alert alert-danger");

        $.ajax({
            type: "POST",
            url: "{{ route('checkout.post') }}",
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
                    $(".form-error-all_errors").html(allErrors).addClass('alert alert-danger');
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