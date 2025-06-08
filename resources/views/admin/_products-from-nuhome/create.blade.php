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
                    <div class="page-header my_style less_margin">
                        <div class="left_section">
                            <div class="title_text">
                                <div class="title">Add New Product</div>
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
                                    <input type="number" name="sr_no" placeholder="Serial Number">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <label>Quality</label>
                                    <div class="error form_error" id="form-error-quality_id"></div>
                                    <select name="quality_id">
                                        <option value="" selected disabled>Select Quality</option>
                                        @foreach ($qualities as $quality)
                                            <option value="{{ $quality->id }}">{{ $quality->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <label>Design Number</label>
                                    <div class="error form_error" id="form-error-design_number_id"></div>
                                    <select name="design_number_id">
                                        <option value="" selected disabled>Select Design Number</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <label>Horizontal Repeat CMS</label>
                                    <div class="error form_error" id="form-error-horizontal_repeat_cms"></div>
                                    <input type="text" name="horizontal_repeat_cms" placeholder="Horizontal Repeat CMS">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <label>Vertical Repeat CMS</label>
                                    <div class="error form_error" id="form-error-vertical_repeat_cms"></div>
                                    <input type="text" name="vertical_repeat_cms" placeholder="Vertical Repeat CMS">
                                </div>
                            </div>
                            <!-- <div class="col-sm-4">
                                <div class="input_box">
                                    <label>GLM</label>
                                    <div class="error form_error" id="form-error-glm"></div>
                                    <input type="number" name="glm" placeholder="GLM">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <label>Martindale</label>
                                    <div class="error form_error" id="form-error-martindale"></div>
                                    <input type="number" name="martindale" placeholder="Martindale">
                                </div>
                            </div> -->
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Care</label>
                                    <div class="error form_error" id="form-error-care"></div>
                                    <textarea name="care" placeholder="Care"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input_box">
                                    <label>Designs</label>
                                    <div class="error form_error" id="form-error-designs"></div>
                                    <select name="designs[]" multiple>
                                        <option value="" disabled>Select Designs</option>
                                        @foreach ($designs as $design)
                                            <option value="{{ $design->id }}">{{ $design->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input_box">
                                    <label>Image</label>
                                    <div class="error form_error" id="form-error-img_file"></div>
                                    <input type="file" name="img_file">
                                    <!-- <input type="hidden" name="existing_img_file" value="1"> -->
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
            url: "{{ route('products.store') }}",
            data:  new FormData(this),
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
                }else{
                    alert(responseData.message || 'An unexpected error occurred.');
                    console.log(responseData.console_message);
                }
            }
        });

    }));

    $('select[name="quality_id"]').on('change', function () {
        var qualityId = $(this).val();

        if (qualityId) {
            $.ajax({
                url: "{{ route('get_design_numbers_by_quality', ':id') }}".replace(':id', qualityId),
                type: 'GET',
                success: function (data) {
                    let $designSelect = $('select[name="design_number_id"]');
                    $designSelect.empty().append('<option value="" disabled selected>Select Design Number</option>');

                    $.each(data, function (key, value) {
                        $designSelect.append('<option value="' + value.id + '">' + value.design_number + '</option>');
                    });
                }
            });
        } else {
            $('select[name="design_number_id"]').empty().append('<option value="" disabled selected>Select Design Number</option>');
        }
    });

});

</script>
            
@endsection