@extends('electrical.layout.master')

@section('content')

<div class="products_list_page">
    
<div class="heading">Copper Lugs</div>

<div class="products_wrapper">
    <div class="container">
        <div class="inner_container">
            
            <div class="left_pane">
                <div class="filters_wrapper">
                    <div class="title">Filters</div>
                    <div id="accordion">
                        <h3>Section 1</h3>
                        <div>
                            <ul>
                                <li>
                                    <label>
                                        <input type="checkbox" name="">
                                        <span class="text">123432</span>
                                        <span class="count">76</span>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="">
                                        <span class="text">123432</span>
                                        <span class="count">76</span>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="">
                                        <span class="text">123432</span>
                                        <span class="count">76</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <h3>Section 2</h3>
                        <div>
                            <p>Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.</p>
                        </div>
                        <h3>Section 3</h3>
                        <div>
                            <p>Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.</p>
                        </div>
                        <h3>Section 4</h3>
                        <div>
                            <p>Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right_pane">
                {{$products->count()}}
            </div>

        </div>
    </div>
</div>
<!-- products_wrapper end -->

</div>
<!-- products_list_page end -->

<script>
  $( function() {
    $( "#accordion" ).accordion({
      collapsible: true
    });
  } );
  </script>
@endsection