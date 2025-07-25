@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Reach Us</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('reach-us.index') }}">Reach Us</a></li>
                    </ul>    
                </div>
                
                <div class="right_section">
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
                <div class="page-header my_style less_margin">
                    <div class="left_section">
                        <div class="title_text">
                            <div class="title">View Reach Us</div>
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
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Name</label>
                                <div class="error form_error" id="form-error-name"></div>
                                <input type="text" name="name" placeholder="Name" value="{{ $result->name }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Email</label>
                                <div class="error form_error" id="form-error-email"></div>
                                <input type="text" name="email" placeholder="Email" value="{{ $result->email }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Phone</label>
                                <div class="error form_error" id="form-error-phone"></div>
                                <input type="text" name="phone" placeholder="Phone" value="{{ $result->phone }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Company_Name</label>
                                <div class="error form_error" id="form-error-company_name"></div>
                                <input type="text" name="company_name" placeholder="Company_Name" value="{{ $result->company_name }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Company_Website</label>
                                <div class="error form_error" id="form-error-company_website"></div>
                                <input type="text" name="company_website" placeholder="Company_Website" value="{{ $result->company_website }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Street_Address</label>
                                <div class="error form_error" id="form-error-street_address"></div>
                                <input type="text" name="street_address" placeholder="Street_Address" value="{{ $result->street_address }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>City</label>
                                <div class="error form_error" id="form-error-city"></div>
                                <input type="text" name="city" placeholder="City" value="{{ $result->city }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>State</label>
                                <div class="error form_error" id="form-error-state"></div>
                                <input type="text" name="state" placeholder="State" value="{{ $result->state }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Country</label>
                                <div class="error form_error" id="form-error-country"></div>
                                <input type="text" name="country" placeholder="Country" value="{{ $result->country }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Postcode</label>
                                <div class="error form_error" id="form-error-postcode"></div>
                                <input type="text" name="postcode" placeholder="Postcode" value="{{ $result->postcode }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Contact_Reason</label>
                                <div class="error form_error" id="form-error-contact_reason"></div>
                                <input type="text" name="contact_reason" placeholder="Contact_Reason" value="{{ $result->contact_reason }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Message</label>
                                <div class="error form_error" id="form-error-message"></div>
                                <textarea>{{ $result->message }}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Document</label>
                                <div class="error form_error" id="form-error-document"></div>
                                <a href="{{ asset('uploads/reach-us-documents/'.$result->document) }}" target="_blank">View Document</a>
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
$(document).ready(function() {
    $("input").prop('disabled', true);
    $("select").prop('disabled', true);
    $(".delete_icon").css({'display':'none'});
    $(".edit_details").css({'display':'none'});
});
</script>
@endsection    