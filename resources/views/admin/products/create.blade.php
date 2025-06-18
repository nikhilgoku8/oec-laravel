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
                                    <label>Category</label>
                                    <div class="error form_error form-error-category_id"></div>
                                    <select name="category_id">
                                        <option value="">Select Category</option>
                                        @if(!empty($categories) && count($categories) > 0)
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <label>Sub Category</label>
                                    <div class="error form_error form-error-sub_category_id"></div>
                                    <select name="sub_category_id" class="custom_select">
                                        <option value="" selected disabled>Sub Category</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <label>Title</label>
                                    <div class="error form_error form-error-title"></div>
                                    <input type="text" name="title" placeholder="Title">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Description</label>
                                    <div class="error form_error form-error-description"></div>
                                    <textarea name="description" placeholder="Description"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input_box">
                                    <label>Features</label>
                                    <div class="error form_error form-error-features"></div>
                                    <textarea name="features" placeholder="Features" class="toolbar"></textarea>
                                </div>
                            </div>
                            <!-- <div class="col-sm-3">
                                <div class="input_box">
                                    <label>Images</label>
                                    <div class="error form_error" id="form-error-img_file"></div>
                                    <input type="file" name="img_file">
                                </div>
                            </div> -->
                            <div class="clr"></div>
                        </div>

                        <div class="filters_wrapper">
                            <div class="filters-section">
                                <div class="input_boxes filter-group">
                                    <!----Product ----->
                                    <div class="col-sm-4">
                                        <div class="input_box">
                                            <label>Filter 1</label>
                                            <div class="error form_error form-error-filters-0-id"></div>
                                            <select name="filters[0][id]" class="filter-id">
                                                <option value="" selected disabled>Select Filter Type</option>
                                                @foreach ($filterTypes as $filterType)
                                                <option value="{{$filterType->id}}">{{$filterType->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="input_box">
                                            <label>Value (Start with @ for custom values)</label>
                                            <div class="error form_error form-error-filters-0-value"></div>
                                            <!-- <input type="text" name="filters[0][value]" placeholder="Value"> -->
                                            <select name="filters[0][value]" class="custom_select">
                                                <option value="" selected disabled>Select Filter Value</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="button" name="button" value="Add Filter" class="add-filter blue_filled_btn">
                        </div>
                        <br>

                        <div class="tabs_wrapper">
                            <div class="tabs-section">
                                <div class="input_boxes tab-group">
                                    <!----Product ----->
                                    <div class="col-sm-4">
                                        <div class="input_box">
                                            <label>Tab 1</label>
                                            <div class="error form_error form-error-tabs-0-id"></div>
                                            <select name="tabs[0][id]">
                                                <option value="" selected disabled>Select Tab Label</option>
                                                @foreach ($productTabLabels as $productTabLabel)
                                                <option value="{{$productTabLabel->id}}">{{$productTabLabel->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input_box">
                                            <label>Content</label>
                                            <div class="error form_error form-error-tabs-0-content"></div>
                                            <textarea name="tabs[0][content]" class="toolbar"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="button" name="button" value="Add Tab" class="add-tab blue_filled_btn">
                        </div>
                        <br>

                        <div class="input_boxes">
                            <div class="col-sm-4">
                                <div class="input_box">
                                    <div class="error form_error form-error-tabs"></div>
                                    <div class="error form_error form-error-filters"></div>
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

        $this = $(this);

        e.preventDefault();
        $this.find(".form_error").html("");
        $this.find(".form_error").removeClass("alert alert-danger");

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
                if (data.status === 422) {
                    let errors = data.responseJSON.errors;
                    $.each(errors, function (key, message) {

                        var fieldName = key.replace(/\./g, '-');
                        $this.find(".form-error-"+fieldName).html(message);
                        $this.find(".form-error-"+fieldName).addClass('alert alert-danger');

                        // $('#form-error-' + key).html(message).addClass('alert alert-danger');
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

    $('select[name="category_id"]').on('change', function () {
        var categoryId = $(this).val();

        var token = $('meta[name="csrf-token"]').attr('content');

        if (categoryId) {
            $.ajax({
                url: "{{ route('get_sub_categories_by_category', ':id') }}".replace(':id', categoryId),
                type: 'POST',
                data: {
                    _token: token
                },
                success: function (data) {
                    let $subCategoriesSelect = $('select[name="sub_category_id"]');
                    $subCategoriesSelect.empty().append('<option value="" disabled selected>Sub Category</option>');

                    $.each(data, function (key, value) {
                        $subCategoriesSelect.append('<option value="' + value.id + '">' + value.title + '</option>');
                    });
                }
            });
        } else {
            $('select[name="sub_category_id"]').empty().append('<option value="" disabled selected>Sub Category</option>');
        }
    });

});


$(document).on('change', '.filter-id', function () {
    let $idSelect = $(this);
    let filterTypeId = $idSelect.val();

    var token = $('meta[name="csrf-token"]').attr('content');

    // Extract index from name, e.g., "filters[0][id]"
    let nameAttr = $idSelect.attr('name');
    let match = nameAttr.match(/^filters\[(\d+)]\[id]$/);
    if (match) {
        let index = match[1];
        let $valueSelect = $(`select[name="filters[${index}][value]"]`);
    // console.log($valueSelect);

        if (!filterTypeId) {
            $valueSelect.html('<option value="">Select Value</option>');
            return;
        }

        // Fetch filter values from server
        $.ajax({
            url: "{{ route('get_filter_values_by_type', ':id') }}".replace(':id', filterTypeId),
            method: 'POST',
            data: { _token: token },
            // success: function (response) {
            //     let options = '<option value="">Select Value</option>';
            //     response.forEach(function (item) {
            //         options += `<option value="${item.id}">${item.label}</option>`;
            //     });
            //     $valueSelect.html(options);
            // },
            // error: function () {
            //     alert('Failed to load filter values');
            //     $valueSelect.html('<option value="">Select Value</option>');
            // }
            success: function (data) {
                // console.log(data);
                $valueSelect.empty().append('<option value="" disabled selected>Select Value</option>');

                $.each(data, function (key, value) {
                    $valueSelect.append('<option value="' + value.id + '">' + value.value + '</option>');
                });

                $(".custom_select").select2({
                    tags:true
                });
            }
        });
    }
});


$(document).on('click', '.add-tab', function() {

    let $tabWrapper = $(this).closest('.tabs_wrapper');
    let $tabsSection = $tabWrapper.find('.tabs-section');
    
    let tabCount = $tabsSection.find('.tab-group').length;

    let newTabGroup = `
        <div class="input_boxes tab-group">
            <div class="col-sm-4">
                <div class="input_box">
                    <label>Tab ${tabCount + 1}</label>
                    <div class="error form_error form-error-tabs-${tabCount}-id"></div>
                    <select name="tabs[${tabCount}][id]">
                        <option value="" selected disabled>Select Tab</option>
                        @foreach ($productTabLabels as $productTabLabel)
                        <option value="{{$productTabLabel->id}}">{{$productTabLabel->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input_box">
                    <label>Content</label>
                    <div class="error form_error form-error-tabs-${tabCount}-content"></div>
                    <textarea name="tabs[${tabCount}][content]" class="toolbar"></textarea>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input_box orange_filled_btn">
                    <button type="button" class="remove-tab">Remove Tab</button>
                </div>
            </div>
        </div>
    `;

    $tabsSection.append(newTabGroup);

    $("select").select2();

    tinymce.init({
        selector: 'textarea.toolbar:not(.mce-initialized)', // skip already initialized
        menubar: false,
        statusbar: false,
        theme: "modern",
        height: 200,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor"
        ],
        content_css: "css/content.css",
        toolbar: "insertfile undo redo | styleselect | bold italic | bullist numlist | link image code | forecolor backcolor",
        style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ],
        setup: function (editor) {
            editor.on('init', function () {
                $(editor.getElement()).addClass('mce-initialized'); // mark as initialized
            });
        }
    });
});

$(document).on('click', '.remove-tab', function() {
    let $tabWrapper = $(this).closest('.tabs_wrapper');
    let $tabsSection = $tabWrapper.find('.tabs-section');

    $(this).closest('.tab-group').remove();

    // Update labels (optional)
    $tabsSection.find('.tab-group').each(function(index) {
        $(this).find('label:first').text(`Tab ${index + 1}`);

        let $productTabLabelSelect = $(this).find('select');
        $productTabLabelSelect.attr('name', `tabs[${index}][id]`);
        $productTabLabelSelect.prev('.form_error').attr('class', `error form_error form-error-tabs-${index}-id`);
        // $productTabLabelSelect.prevAll('.form_error').first().attr('class', `error form_error form-error-tabs-${index}-id`);

        let $productTabLabelContent = $(this).find('textarea');
        $productTabLabelContent.attr('name', `tabs[${index}][content]`);
        $productTabLabelContent.prev('.form_error').attr('class', `error form_error form-error-tabs-${index}-content`);
        // $productTabLabelContent.prevAll('.form_error').first().attr('class', `error form_error form-error-tabs-${index}-content`);

    });
});


$(document).on('click', '.add-filter', function() {

    let $filterWrapper = $(this).closest('.filters_wrapper');
    let $filtersSection = $filterWrapper.find('.filters-section');
    
    let filterCount = $filtersSection.find('.filter-group').length;

    let newFilterGroup = `
        <div class="input_boxes filter-group">
            <div class="col-sm-4">
                <div class="input_box">
                    <label>Filter ${filterCount + 1}</label>
                    <div class="error form_error form-error-filters-${filterCount}-id"></div>
                    <select name="filters[${filterCount}][id]" class="filter-id">
                        <option value="" selected disabled>Select Filter Type</option>
                        @foreach ($filterTypes as $filterType)
                        <option value="{{$filterType->id}}">{{$filterType->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="input_box">
                    <label>Value (Start with @ for custom values)</label>
                    <div class="error form_error form-error-filters-${filterCount}-value"></div>    
                    <select name="filters[${filterCount}][value]" class="custom_select">
                        <option value="" selected disabled>Select Filter Value</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="input_box orange_filled_btn">
                    <button type="button" class="remove-filter">Remove Filter</button>
                </div>
            </div>
        </div>
    `;

    $filtersSection.append(newFilterGroup);

    $("select").select2();

    $(".custom_select").select2({
        tags:true
    });
});

$(document).on('click', '.remove-filter', function() {
    let $filterWrapper = $(this).closest('.filters_wrapper');
    let $filtersSection = $filterWrapper.find('.filters-section');

    $(this).closest('.filter-group').remove();

    // Update labels (optional)
    $filtersSection.find('.filter-group').each(function(index) {
        $(this).find('label:first').text(`Filter ${index + 1}`);

        let $productFilterLabelSelect = $(this).find('select');
        $productFilterLabelSelect.attr('name', `filters[${index}][id]`);
        $productFilterLabelSelect.prev('.form_error').attr('class', `error form_error form-error-filters-${index}-id`);

        let $productFilterLabelContent = $(this).find('textarea');
        $productFilterLabelContent.attr('name', `filters[${index}][content]`);
        $productFilterLabelContent.prev('.form_error').attr('class', `error form_error form-error-filters-${index}-content`);

    });
});
</script>

@endsection