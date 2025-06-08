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
                    <div class="purple_hollow_btn">
                        <a href="{{ route('products.create'); }}">Add New</a>
                    </div>
                    <!-- <div class="orange_hollow_btn">
                        <a id="filter_option">Filter</a>
                    </div> -->
                </div>
            </div>                    
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="fourth_row">
            
            <div class="my_panel">
                
                @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger">{{Session::get('error')}}</div>
                @endif


                <div class="upper_sec">
                    <div class="left_section">
                        <div class="title">Products Data</div>
                        <div class="sub_title"> </div>
                    </div>
                    <div class="right_section">
                        <div class="orange_filled_btn">
                            <a id="delete_records">Delete</a>
                        </div>
                    </div>
                </div>
                <div class="details_table">
                    <table>
                        <tbody>
                            <tr>
                                <th>Product Sr No</th>
                                <th>Design Number</th>
                                <th>Quality</th>
                                <th>Image</th>
                                <th>Design</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th class="action">ACTION</th>
                            </tr>
                            @if(!empty($result))
                                @foreach ($result as $row)
                                    <tr>
                                        <td>{{ $row->sr_no }}</td>
                                        <td><a href="{{ route('design_numbers.edit', $row->designNumber->id) }}">{{ $row->designNumber->design_number }}</a></td>
                                        <td><a href="{{ route('qualities.edit', $row->designNumber->quality->id) }}">{{ $row->designNumber->quality->name }}</a></td>
                                        <td>
                                            <a href="{{ asset('storage/uploads/products/'.$row->img_file) }}" target="_blank">{{$row->img_file}}</a>
                                        </td>
                                        <!-- <td>
                                            @if(!empty($row->qualities))
                                                @foreach($row->qualities as $quality)
                                                    @if($loop->iteration != 1)
                                                    ,
                                                    @endif
                                                    {{$quality->name}}
                                                @endforeach
                                            @endif
                                        </td> -->
                                        <td>
                                            @if(!empty($row->designs))
                                                @foreach($row->designs as $design)
                                                    @if($loop->iteration != 1)
                                                    ,
                                                    @endif
                                                    {{$design->name}}
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $row->created_by }} <br> {{ $row->created_at }}</td>
                                        <td>{{ $row->updated_by }} <br> {{ $row->updated_at }}</td>
                                        <td class="action">
                                            <a href="{{ route('products.edit', $row->id) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            @if(!in_array($row->id, $mainProductIds))
                                            <span class="checkbox">
                                                <input name="dataID" class="styled" type="checkbox" value="{{ $row->id }}">
                                                <label for="checkbox1"></label>
                                            </span>
                                            @else
                                                <span>Design Number <br>Main <br>Product</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="table_pagination">
                    {{ $result->links() }}
                    <div class="clr"></div>
                </div>
            </div>

        </div>
        <!-- fourth_row end -->
    </div>
    <!-- /.row -->    

<script type="text/javascript">
$(document).ready(function() {

  $("#delete_records").on('click',(function(e){
    e.preventDefault();

    var dataID = [];
    $.each($("input[name='dataID']:checked"), function(){
        dataID.push($(this).val());
    });

    if(dataID.length == 0){
        alert('No records are selected');
    }else{
        if (confirm('Are you sure you want to delete these records?')) {
            $.ajax({
                type: "POST",
                url: "{{ route('products.bulk-delete') }}",
                data: {"_token":"{{ csrf_token() }}", "dataID":dataID},
                dataType: 'json',
                success: function(response) {
                    window.location.reload(true);
                },
                error: function(data){
                    console.log(data.message);
                    console.log(data.responseJSON.message);
                }
            });
        }
    }  

  }));

});
</script>

@endsection