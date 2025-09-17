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
                <input type="hidden" name="dataID" value="{{ $result->id }}">
                <div class="page-header my_style less_margin">
                    <div class="left_section">
                        <div class="title_text">
                            <div class="title">View Sales Representative</div>
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
                                <input type="text" name="rep_name" placeholder="Sales Representative Name" value="{{ $result->rep_name }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Address</label>
                                <div class="error form_error" id="form-error-address"></div>
                                <input type="text" name="address" placeholder="Address" value="{{ $result->address }}">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Website</label>
                                <div class="error form_error" id="form-error-website"></div>
                                <input type="text" name="website" placeholder="Website" value="{{ $result->website }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Email</label>
                                <div class="error form_error" id="form-error-email"></div>
                                <input type="text" name="email" placeholder="Email" value="{{ $result->email }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Phone</label>
                                <div class="error form_error" id="form-error-phone"></div>
                                <input type="text" name="phone" placeholder="Phone" value="{{ $result->phone }}">
                            </div>
                        </div>
                        @php
                            $state_ids = $result->usStates()->pluck('us_state_id')->toArray();
                        @endphp
                        @if(!empty($usStates) && count($usStates) > 0)
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>US States</label>
                                <div class="error form_error" id="form-error-state_id"></div>
                                <select name="state_id[]" multiple>
                                    <option value="">Select US States</option>
                                    @foreach($usStates as $state)
                                    <option value="{{ $state->id }}" @selected(in_array($state->id, $state_ids))>{{ $state->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
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