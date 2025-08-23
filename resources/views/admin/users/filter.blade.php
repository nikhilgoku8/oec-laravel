<div class="filter_box {{ (request()->has('q') || request('fname') || request('lname') || request('email') || request('phone') || request('status')) ? 'show' : '' }}" id="filter_box">
        <div class="row">
            <div class="my_panel">
                <div class="inner_box ">
                    <div class="upper_sec">
                        <div class="left_section">
                            <div class="title">
                                Filter Data
                                <div class="error form_error" id="form-error-custom_error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="filter_form">
                        <form id="filter_form" action="{{ route('users.index') }}" method="GET">
                        <!-- @@csrf -->
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>First Name</label>
                                <div class="error form_error" id="form-error-fname"></div>
                                <input type="text" name="fname" placeholder="First Name" value="{{ request('fname') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Last Name</label>
                                <div class="error form_error" id="form-error-lname"></div>
                                <input type="text" name="lname" placeholder="Last Name" value="{{ request('lname') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Email</label>
                                <div class="error form_error" id="form-error-email"></div>
                                <input type="text" name="email" placeholder="Email" value="{{ request('email') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Phone</label>
                                <div class="error form_error" id="form-error-phone"></div>
                                <input type="text" name="phone" placeholder="Phone" value="{{ request('phone') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Status</label>
                                <div class="error form_error" id="form-error-status"></div>
                                <select name="status">
                                    <option value="">Select Status</option>
                                    <option value="pending" @if(request('status') == 'pending') selected @endif>Pending</option>
                                    <option value="approved" @if(request('status') == 'approved') selected @endif>Approved</option>
                                    <option value="denied" @if(request('status') == 'denied') selected @endif>Denied</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <span class="input_box purple_filled_btn">
                                <button type="submit" name="submit">Search</button>
                            </span>
                            <span class="input_box orange_hollow_btn">
                                <button type="submit" formaction="{{ route('users.export') }}">Export</button>
                            </span>
                            <span class="input_box blue_filled_btn">
                                <a href="{{ route('users.index').'?q=' }}">Clear Filters</a>
                            </span>
                        </div>
                        <!-- <div class="col-sm-2">
                            <div class="input_box blue_filled_btn">
                                <a href="{{ route('users.index') }}" class="">Clear Filters</a>
                            </div>
                        </div> -->
                        <!-- <div class="col-sm-2">
                            <div class="countAjaxResult">
                                Result : <span id="countAjaxResult">0</span>
                            </div>
                        </div> -->
                        </form>
                    </div>
                    <div class="clr"></div>
                </div>
                <!-- patients_filter_box end -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- patients_filter end -->


<!-- <script type="text/javascript">
$(document).ready(function() {
    
    $("#filter_form").on('submit',(function(e){
        e.preventDefault();

        $(".form_error").html('');
        $(".form_error").removeClass('alert alert-danger');
        $('button[type="submit"]').prop('disabled', true);

        $.ajax({
            type: "GET",
            url: "{{ url('ewm/patients/filter') }}",
            data:  new FormData(this),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                // console.log(result.html);
                $("#filter_result").html(result.html);
                // var rowCount = $(".details_table tbody").html(result.html).find('tr.ajaxRow').length;
                // $("#countAjaxResult").html(rowCount);
            },
            complete: function(){
                $('button[type="submit"]').prop('disabled', false);
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

    // $("#export_btn").on('click',(function(){
    //     var name = $("#filter_fname").val();
    //     var mobile = $("#filter_mobile").val();

    //     window.location.href = "<?php echo URL::to('/'); ?>/ewm/doctors/export?name="+name+"&mobile="+mobile;
    // }));

});
</script> -->