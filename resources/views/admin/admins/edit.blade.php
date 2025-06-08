@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Admins</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ url('nwm/dashboard'); }}">Home</a></li>
                        <li><a href="{{ url('nwm/admins'); }}">Admins</a></li>
                    </ul>    
                </div>
                
                <div class="right_section">
                    <div class="blue_filled_btn">
                        <a href="nwm/admins">Back</a>
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
                            <div class="title">Edit Admin</div>
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
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Name</label>
                                <div class="error form_error" id="form-error-name"></div>
                                <input type="text" name="name" placeholder="Name" value="{{ $result->name }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Email</label>
                                <div class="error form_error" id="form-error-email"></div>
                                <input type="text" name="email" placeholder="Email" value="{{ $result->email }}">
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="input_boxes">
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Password</label>
                                <div class="error form_error" id="form-error-password"></div>
                                <input type="text" name="password" placeholder="Password">
                                <p>
                                    <ul>
                                        <li>Should have At least one Uppercase letter.</li>
                                        <li>At least one Lower case letter.</li>
                                        <li>Also,At least one numeric value.</li>
                                        <li>And, At least one special character.</li>
                                        <li>Must be more than 6 characters long.</li>
                                    </ul>
                                </p>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="input_boxes">
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Role</label>
                                <div class="error form_error" id="form-error-role"></div>
                                <select name="role" id="role">
                                    <option value="">Select Role</option>
                                    <option value="executive" @if($result->role=='executive') {{ 'selected' }} @endif>Executive</option>
                                    <option value="manager" @if($result->role=='manager') {{ 'selected' }} @endif>Manager</option>
                                    <option value="dispatch" @if($result->role=='dispatch') {{ 'selected' }} @endif>Dispatch</option>
                                    <option value="admin" @if($result->role=='admin') {{ 'selected' }} @endif>Admin</option>
                                    <option value="superadmin" @if($result->role=='superadmin') {{ 'selected' }} @endif>Super Admin</option>
                                </select>
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
            url: "<?php echo URL::to('/'); ?>/nwm/admins/store",
            data:  new FormData(this),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="<?php echo URL::to('/'); ?>/nwm/admins/";
            },
            error: function(data){
                var responseData = data.responseJSON;        
                if(responseData.error_type=='form'){
                    jQuery.each( responseData.errors, function( i, val ) {
                        $("#form-error-"+i).html(val);
                        $("#form-error-"+i).addClass('alert alert-danger');
                    });
                }
            }
        });

    }));


    $("#state_id").on('change', function(){
        
        var state_id = $(this).val();        

        $.ajax({
            type: "POST",
            url: "<?php echo URL::to('/'); ?>/nwm/admins/getData_cities",
            data: {"_token":"{{ csrf_token() }}", "state_id":state_id},
            dataType: 'json',
            success: function(result) {
                $("#city_id option").remove();
                $("#city_id").append('<option value="">Select City</option>');
                jQuery.each( result, function( i, val ) {                    
                    $("#city_id").append('<option value="'+val['id']+'">'+val['name']+'</option>');
                });
            },
            error: function(data){
                
            }
        });

    });

});
</script>
            
@endsection    