@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Admins</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ url('owm/admins'); }}">Admins</a></li>
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
                <div class="page-header my_style less_margin">
                    <div class="left_section">
                        <div class="title_text">
                            <div class="title">Add New Admin</div>
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
                                <input type="text" name="name" placeholder="Name">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Email</label>
                                <div class="error form_error" id="form-error-email"></div>
                                <input type="text" name="email" placeholder="Email">
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
                                    <option value="executive">Executive</option>
                                    <option value="manager">Manager</option>
                                    <option value="dispatch">Dispatch</option>
                                    <!-- <option value="admin">Admin</option> -->
                                    <option value="superadmin">Super Admin</option>
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
            url: "<?php echo URL::to('/'); ?>/owm/admins/store",
            data:  new FormData(this),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="<?php echo URL::to('/'); ?>/owm/admins/";
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


});
</script>
            
@endsection    