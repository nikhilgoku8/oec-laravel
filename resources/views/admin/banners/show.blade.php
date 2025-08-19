@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Banners</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('banners.index') }}">Banners</a></li>
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
                            <div class="title">View Banner</div>
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
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Image File (1920x650px)</label>
                                <div class="error form_error" id="form-error-image_file"></div>
                                @if(!empty($result->image_file))
                                <div class="existing_file_wrapper">
                                    To replace <a href="{{ asset('uploads/banners/'.$result->image_file) }}" target="_blank"><img src="{{ asset('uploads/banners/'.$result->image_file) }}" width="100px"></a> select below
                                </div>
                                <input type="hidden" name="existing_image_file" value="{{ $result->image_file }}">
                                @endif
                                <input type="file" name="image_file">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Link</label>
                                <div class="error form_error" id="form-error-link"></div>
                                <input type="text" name="link" placeholder="https://www.example.com">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Sort Order</label>
                                <div class="error form_error" id="form-error-sort_order"></div>
                                <input type="number" name="sort_order" placeholder="Sort Order" value="{{ $result->sort_order }}">
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