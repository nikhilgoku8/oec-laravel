@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Careers</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('careers.index') }}">Careers</a></li>
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
                            <div class="title">View Career</div>
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
                                <label>Position</label>
                                <div class="error form_error" id="form-error-position"></div>
                                <input type="text" name="position" placeholder="Position" value="{{ $result->position }}">
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
                                <label>Resume</label>
                                <div class="error form_error" id="form-error-resume"></div>
                                <a href="{{ asset('uploads/resumes/'.$result->resume) }}" target="_blank">View Resume</a>
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