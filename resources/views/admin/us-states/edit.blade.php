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
                            <div class="title">Edit US State</div>
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

    <div class="row">
        <div class="my_panel form_box">
            
            @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">{{Session::get('error')}}</div>
            @endif

            <form id="sort_sub_us-states" action="" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="dataID" value="{{ $result->id }}">
            <div class="page-header my_style less_margin">
                <div class="left_section">
                    <div class="title_text">
                        <div class="title">Edit Sub US States Sort Order</div>
                        <div class="sub_title">Drag and drop then save to make the changes</div>
                    </div>
                </div>
                <div class="right_section">
                    <div class="purple_filled_btn">
                        <!-- <a class="save-order">Save</a> -->
                        <!-- <button type="button" class="btn btn-primary save-banners-order">Save Order</button> -->
                    </div>
                </div>
            </div>

            <div class="inner_boxes">
                <div class="sorting_wrapper">
                    <ul id="sortable">
                    @if(!empty($result->subUS States))
                        @foreach($result->subUS States as $subUS State)
                            <li class="ui-state-default" data-id="{{ $subUS State->id }}">
                                <div class="title">{{ $subUS State->title }}</div>
                                <div class="sort_order">{{ $subUS State->sort_order }}</div>
                            </li>
                        @endforeach
                    @else
                        No Banners
                    @endif
                    </ul>
                </div>
                <div class="input_boxes"><div class="input_box"></div></div>
                <div class="input_boxes">
                    <div class="col-sm-4">
                        <div class="input_box">
                            <button type="button" class="btn btn-primary save-banners-order">Save Order</button>
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- /.row -->

<script>
  $(document).ready(function() {
    const $draggable = $('.ui-state-default');

    $draggable.on('mousedown', function() {
      $(this).addClass('grabbing');
    });

    $(document).on('mouseup', function() {
      $draggable.removeClass('grabbing');
    });
  });



</script>

<script>
$( function() {
    $( "#sortable" ).sortable({
        revert: true
    });

    // $( "#draggable" ).draggable({
    //   connectToSortable: "#sortable",
    //   helper: "clone",
    //   revert: "invalid"
    // });

    $( "ul, li" ).disableSelection();

    $('.save-banners-order').click(function() {
        let sortedIds = [];
        $('ul#sortable li').each(function(index) {
            sortedIds.push({
                id: $(this).data('id'),
                sort_order: index + 1 // +1 if you want it 1-based
            });
        });

        // console.log(sortedIds);

        $.ajax({
            // url: '/nwm/collections/{{ $result->id }}/sort-banners',
            url: "{{ route('us-states.sortSubUS States', $result->id) }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                sorted: sortedIds
            },
            success: function(response) {
                alert('Sort order saved successfully!');
                window.location.reload();
            },
            error: function(xhr) {
                alert('Something went wrong');
            }
        });
    });

});

</script>

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
            url: "{{ route('us-states.update', $result->id) }}",
            data:  formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="{{ route('us-states.index') }}";
            },
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