@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Orders</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('orders.index') }}">Orders</a></li>
                    </ul>    
                </div>
                
                <div class="right_section">
                    <div class="purple_filled_btn print_btn">
                        <input type="button" name="print" value="Print" class="btn btn-primary" onclick="printInvoice()">
                    </div>
                    <div class="blue_filled_btn">
                        <a href="{{ url()->previous() }}">Back</a>
                    </div>
                </div>
            </div>                    
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">

            <div class="my_panel form_box">
                <form id="data_form" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="dataID" value="{{ $result->id }}">
                    <div class="page-header my_style less_margin no_print">
                        <div class="left_section">
                            <div class="title_text">
                                <div class="title">View Order</div>
                                <div class="sub_title">Please fillup the form </div>
                            </div>
                        </div>
                        <div class="right_section">
                            <!-- <div class="purple_filled_btn">
                                <a href="#">Save</a>
                            </div> -->
                        </div>
                    </div>

                    <div class="inner_boxes">

                        <div class="input_boxes">
                            <div class="col-sm-12 print_width_100">
                                <div class="input_box">
                                    <label>Order Ref Id</label>
                                    <input type="text" name="order_ref_id" value="{{ $result->order_ref_id }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12 print_width_100">
                                <div class="input_box">
                                    <label>Products</label>
                                    @if(!empty($result->orderProducts) && count($result->orderProducts) > 0)
                                        <div class="products_wrapper">
                                            @foreach($result->orderProducts as $orderProduct)
                                                <div class="product_box">
                                                    <div class="img_box">
                                                        <img src="{{ $orderProduct->product->productImages?->first()->image_file }}" width="100px">
                                                    </div>
                                                    <div class="product_title">{{ $orderProduct->product->title }}</div>
                                                    <div class="quantity">x{{ $orderProduct->quantity }}</div>
                                                    <a href="{{ route('products.show', $orderProduct->product->id ) }}" target="_blank" class="view_product">View</a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4 print_width_50">
                                <div class="input_box">
                                    <label>First Name</label>
                                    <input type="text" name="title" value="{{ $result->billing_fname }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-4 print_width_50">
                                <div class="input_box">
                                    <label>Last Name</label>
                                    <input type="text" name="title" value="{{ $result->billing_lname }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-4 no_print">
                                <div class="input_box">
                                    <a href="{{ route('users.show', $result->user_id) }}" target="_blank">View User</a>
                                </div>
                            </div>
                            <div class="col-sm-4 print_width_50">
                                <div class="input_box">
                                    <label>Email</label>
                                    <input type="text" name="title" value="{{ $result->billing_email }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-4 print_width_50">
                                <div class="input_box">
                                    <label>Phone</label>
                                    <input type="text" name="title" value="{{ $result->billing_phone }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Company</label>
                                    <input type="text" name="title" value="{{ $result->billing_company }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12 print_width_50">
                                <div class="input_box">
                                    <label>Country</label>
                                    <input type="text" name="title" value="{{ $result->billing_country }}" disabled>
                                </div>
                            </div>
                            <div class="col-sm-12 print_width_100">
                                <div class="input_box">
                                    <label>Enquiry Notes</label>
                                    <textarea disabled>{{ $result->enquiry_notes }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 print_width_50">
                                <div class="input_box">
                                    <label>Status*</label>
                                    <div class="error form_error" id="form-error-status"></div>
                                    <select name="status">
                                        <option value="pending" @if($result->status == 'pending') selected @endif>Pending</option>
                                        <option value="completed" @if($result->status == 'completed') selected @endif>Completed</option>
                                        <option value="denied" @if($result->status == 'denied') selected @endif>Denied</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 print_width_50">
                                <div class="input_box">
                                    <label>Admin Remark</label>
                                    <div class="error form_error" id="form-error-admin_remark"></div>
                                    <textarea name="admin_remark">{{ $result->admin_remark }}</textarea>
                                </div>
                            </div>
                            <div class="clr"></div>
                        </div>
                    </div>
                </form>
            </div>

    </div>
    <!-- /.row -->

<script type="text/javascript">
    function printInvoice() {
        // Dynamically add print-specific CSS
        var printCss = `
            <style>
                @media print {
                    body, html {
                        margin: 0;
                        padding: 0;
                        height: 100%;
                        position: relative;
                    }

                    body * {
                        visibility: hidden;
                    }

                    #data_form, #data_form * {
                        visibility: visible;
                        position: relative;
                        top: 0;
                        left: 0;
                    }

                    #data_form {
                        position: absolute;
                        top: 0;
                        left: 0;
                        margin: 0;
                        padding: 0;
                        width: 100%;
                        height: auto;
                    }

                    .no_print{
                        display: none !important;
                    }

                    .print_width_50{
                        width: 50%;
                    }

                    .print_width_100{
                        width: 100%;
                    }

                    #data_form {
                        // position: fixed;
                        // top: 0;
                        // left: 0;
                        // margin: 0;
                        // padding: 0;
                        // width: 100%;
                        // height: auto;
                    }

                    #data_form .view_product{
                        display: none;
                    }
                }
            </style>
        `;
        
        // Append the style to the head of the document
        $('head').append(printCss);

        // Trigger the browser's print dialog
        window.print();
    }
</script>

<script type="text/javascript">
$(document).ready(function() {
    $("input").prop('disabled', true);
    $("select").prop('disabled', true);
    $(".delete_icon").css({'display':'none'});
    $(".edit_details").css({'display':'none'});
    $("[name=print]").prop('disabled', false);
});
</script>
@endsection    