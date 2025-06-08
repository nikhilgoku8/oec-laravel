@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Products</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">Products</a></li>
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
                                <div class="title">Edit Product</div>
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
                                    <label>Serial Number</label>
                                    <div class="error form_error" id="form-error-sr_no"></div>
                                    <input type="number" name="sr_no" placeholder="Serial Number" value="{{ $result->sr_no }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <label>Quality</label>
                                    <div class="error form_error" id="form-error-quality_id"></div>
                                    <select name="quality_id">
                                        <option value="" disabled>Select Quality</option>
                                        @foreach ($qualities as $quality)
                                            <option value="{{ $quality->id }}"
                                                {{ (isset($result) && $result->quality_id == $quality->id) ? 'selected' : '' }}>
                                                {{ $quality->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <label>Horizontal Repeat CMS</label>
                                    <div class="error form_error" id="form-error-horizontal_repeat_cms"></div>
                                    <input type="text" name="horizontal_repeat_cms" placeholder="Horizontal Repeat CMS" value="{{ $result->horizontal_repeat_cms }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <label>Vertical Repeat CMS</label>
                                    <div class="error form_error" id="form-error-vertical_repeat_cms"></div>
                                    <input type="text" name="vertical_repeat_cms" placeholder="Vertical Repeat CMS" value="{{ $result->vertical_repeat_cms }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input_box">
                                    <label>Designs</label>
                                    <div class="error form_error" id="form-error-designs"></div>
                                    <select name="designs[]" multiple>
                                        <option value="" disabled>Select Designs</option>
                                        @foreach ($designs as $design)
                                            <option value="{{ $design->id }}"
                                                {{ isset($result) && $result->designs->contains($design->id) ? 'selected' : '' }}>
                                                {{ $design->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input_box">
                                    <label>Image</label>
                                    <div class="error form_error" id="form-error-img_file"></div>
                                    @if(!empty($result->img_file))
                                    <div class="existing_file_wrapper">
                                        To replace <a href="{{ asset('storage/uploads/products/'.$result->img_file) }}" target="_blank">Existing Image File</a> select below
                                    </div>
                                    <input type="hidden" name="existing_img_file" value="{{ $result->img_file }}">
                                    @endif
                                    <input type="file" name="img_file">
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

        var formData = new FormData(this);
        formData.append('_method', 'PUT'); // <-- This is important!

        $.ajax({
            type: "POST",
            url: "{{ route('products.update', $result->id) }}",
            data:  formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="{{ route('products.index') }}";
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