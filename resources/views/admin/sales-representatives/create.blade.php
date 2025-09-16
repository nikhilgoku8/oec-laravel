@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Sales Representatives</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('sales-representatives.index') }}">Sales Representatives</a></li>
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
                <div class="page-header my_style less_margin">
                    <div class="left_section">
                        <div class="title_text">
                            <div class="title">Add New Sales Representative</div>
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
                                <label>Sales Representative Name</label>
                                <div class="error form_error" id="form-error-rep_name"></div>
                                <input type="text" name="rep_name" placeholder="Sales Representative Name">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Address</label>
                                <div class="error form_error" id="form-error-address"></div>
                                <input type="text" name="address" placeholder="Address">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Website</label>
                                <div class="error form_error" id="form-error-website"></div>
                                <input type="text" name="website" placeholder="Website">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Email</label>
                                <div class="error form_error" id="form-error-email"></div>
                                <input type="text" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Phone</label>
                                <div class="error form_error" id="form-error-phone"></div>
                                <input type="text" name="phone" placeholder="Phone">
                            </div>
                        </div>
                        @if(!empty($usStates) && count($usStates) > 0)
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>US States</label>
                                <div class="error form_error" id="form-error-state_id"></div>
                                <select name="state_id[]" multiple>
                                    <option value="">Select US States</option>
                                    @foreach($usStates as $state)
                                    <option value="{{ $state->id }}">{{ $state->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
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
            url: "{{ route('sales-representatives.store') }}",
            data:  new FormData(this),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="{{ route('sales-representatives.index') }}";
            },
            // error: function(data){
            //     var responseData = data.responseJSON;
            //     if(responseData.error_type=='form'){
            //         jQuery.each( responseData.errors, function( i, val ) {
            //             $("#form-error-"+i).html(val);
            //             $("#form-error-"+i).addClass('alert alert-danger');
            //         });
            //     }else{
            //         alert(responseData.message || 'An unexpected error occurred.');
            //         console.log(responseData.console_message);
            //     }
            // }
            error: function(data){
                if (data.status === 422) {
                    let errors = data.responseJSON.errors;
                    $.each(errors, function (key, message) {
                        $('#form-error-' + key).html(message).addClass('alert alert-danger');
                    });
                } else if (data.status === 401) {
                    alert("Please log in.");
                    // window.location.href = "/login";
                } else if (data.status === 403) {
                    alert("You don’t have permission.");
                } else if (data.status === 404) {
                    alert("The resource was not found.");
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