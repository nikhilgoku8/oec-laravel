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
                <div class="list_heading">
                    <div class="breadcrumbs">
                        <ul>
                            <li><a class="txt" href="{{ route('electrical') }}">Home</a></li>
                            <li><a class="txt" href="{{ route('sub-categories', $category->slug) }}">{{ $category->title }}</a></li>
                            <li><span class="txt">{{ $subCategory->title }}</span></li>
                        </ul>
                    </div>
                    <div class="total_count_text">
                        @if ($products->total() > 0)
                            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
                        @endif
                    </div>
                </div>
                <div class="products_list">
                    @foreach($products as $product)
                        <div class="product_box">
                            <a href="{{ route('product', [
                                    'category' => $category->slug,
                                    'subCategory' => $subCategory->slug,
                                    'product' => $product->id
                                ]) }}" class="img_box">
                                <img src="{{ $product->productImages?->first()->image_file }}">
                            </a>
                            <div class="text_box">
                                <a href="{{ route('product', [
                                    'category' => $category->slug,
                                    'subCategory' => $subCategory->slug,
                                    'product' => $product->id
                                ]) }}" class="product_title">{{ $product->title }}</a>
                                <div class="sub_category_title">{{ $subCategory->title }}</div>
                                <div class="description">{{ $product->description }}</div>
                                <button class="red_filled_btn">Add To Enquiry</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="page_links">
                    {{ $products->onEachSide(3)->links('pagination.numbers') }}
                </div>
                <!-- @{{ $products->links('pagination::bootstrap-5') }} -->
                <!-- @if ($products->total() > 0)
                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
                @else
                    No results found.
                @endif -->
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