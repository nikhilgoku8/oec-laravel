<div class="filter_box {{ (request('user_id') || request('order_ref_id') || request('status')) ? 'show' : '' }}" id="filter_box">
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
                        <form id="filter_form" action="{{ route('orders.index') }}" method="GET">
                        <!-- @@csrf -->
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>User</label>
                                <div class="error form_error" id="form-error-user_id"></div>
                                <select name="user_id">
                                    <option value="">Select User</option>
                                    @if(!empty($users) && count($users) > 0)
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" @if(request('user_id') == $user->id) selected @endif>{{ $user->fname .' '. $user->lname }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Order Ref Id</label>
                                <div class="error form_error" id="form-error-order_ref_id"></div>
                                <input type="text" name="order_ref_id" placeholder="Order Ref Id" value="{{ request('order_ref_id') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Status</label>
                                <div class="error form_error" id="form-error-status"></div>
                                <select name="status">
                                    <option value="">Select Status</option>
                                    <option value="pending" @if(request('status') == 'pending') selected @endif>Pending</option>
                                    <option value="completed" @if(request('status') == 'completed') selected @endif>Completed</option>
                                    <option value="denied" @if(request('status') == 'denied') selected @endif>Denied</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input_box">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input_box blue_filled_btn">
                                <a href="{{ route('orders.index') }}" class="">Clear Filters</a>
                            </div>
                        </div>
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