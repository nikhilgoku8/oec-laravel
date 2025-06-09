@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Admins</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ url('owm/dashboard'); }}">Home</a></li>
                        <li><a href="{{ url('owm/admins'); }}">Admins</a></li>
                        <li><a href="{{ url('owm/admins/edit/'.$result->id) }}">{{ $result->fname }}</a></li>
                    </ul>    
                </div>
                
                <div class="right_section">
                    <div class="blue_filled_btn">
                        <a href="owm/admins">Back</a>
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
                            <div class="title">Google 2FA Setup</div>
                            <div class="sub_title">Scan below QR and enter OTP</div>
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
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Name</label>
                                <input type="text" name="fname" placeholder="Name" value="{{ $result->fname }}" disabled>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Email</label>
                                <input type="text" name="email" placeholder="Email" value="{{ $result->email }}" disabled>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="input_boxes">
                        <div class="col-sm-12">
                            <div class="input_box">
                                {!! $qrCodeSvg !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>OTP (6 digits)</label>
                                <div class="error form_error" id="form-error-otp"></div>
                                <input type="number" name="otp" placeholder="OTP">
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="input_boxes">
                        <div class="col-sm-4">
                            <div class="input_box">
                                <input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary">
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

    $("#data_form").on('submit',(function(e){
        e.preventDefault();
        $(".form_error").html("");
        $(".form_error").removeClass("alert alert-danger");

        $.ajax({
            type: "POST",
            url: "{{ url('owm/admins/confirm2FA') }}",
            data:  new FormData(this),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="{{ url('owm/admins') }}";
            },
            error: function(data){
                var responseData = data.responseJSON;        
                    // console.log(responseData.errors);
                    // console.log($.isArray(responseData.errors));
                if(responseData.error_type=='form'){
                    jQuery.each( responseData.errors, function( i, val ) {
                        $("#form-error-"+i).html(val);
                        $("#form-error-"+i).addClass('alert alert-danger');
                    });
                }else if(responseData.errors){
                    jQuery.each( responseData.errors, function( i, val ) {
                        $("#form-error-"+i).html(val);
                        $("#form-error-"+i).addClass('alert alert-danger');
                    });
                }else{
                    console.log(data);
                }
            }
        });

    }));


});
</script>
            
@endsection    