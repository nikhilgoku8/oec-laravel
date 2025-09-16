@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">US States</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('us-states.index') }}">US States</a></li>
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
                            <div class="title">View US State</div>
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
                                <label>Title</label>
                                <div class="error form_error" id="form-error-title"></div>
                                <input type="text" name="title" placeholder="Title" value="{{ $result->title }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input_box">
                                <label>Abbrevation</label>
                                <div class="error form_error" id="form-error-abbr"></div>
                                <input type="text" name="abbr" placeholder="Abbrevation" value="{{ $result->abbr }}">
                            </div>
                        </div>
                        @php
                            $rep_ids = $result->salesRepresentatives()->pluck('id')->toArray();
                        @endphp
                        @if(!empty($salesRepresentatives) && count($salesRepresentatives) > 0)
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Sales Representatives</label>
                                <div class="error form_error" id="form-error-rep_id"></div>
                                <select name="rep_id[]" multiple>
                                    <option value="">Select Sales Representatives</option>
                                    @foreach($salesRepresentatives as $rep)
                                    <option value="{{ $rep->id }}" @selected(in_array($rep->id, $rep_ids))>{{ $rep->rep_name }}</option>
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