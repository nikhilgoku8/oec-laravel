@extends('electrical.layout.master')

@section('content')

<div class="competitors_page">
    
<div class="heading">Competitors</div>

<div class="products_wrapper">
    <div class="container">
        <div class="inner_container">

            @if (session('success'))
                <div class="col-sm-12">
                    <div class="alert alert-success center title">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            <div class="competitors_wrapper">
                <div class="competitors_search_wrapper">
                    <form method="GET" action="{{ route('competitors.search') }}" class="competitors_search">
                        <div class="input_box">
                            <input type="text" class="search_input" name="q" placeholder="Search Competitors" value="{{ request('q') }}">
                        </div>
                        <button class="icon_box"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="list_heading">
                    <!-- <div class="breadcrumbs">
                        <ul>
                            <li><a class="txt" href="{{ route('electrical') }}">Home</a></li>
                            <li><span class="txt">Shop</span></li>
                        </ul>
                    </div> -->
                    <!-- <div class="total_count_text">
                        @if ($competitors->total() > 0)
                            Showing {{ $competitors->firstItem() }} to {{ $competitors->lastItem() }} of {{ $competitors->total() }} results
                        @endif
                    </div> -->
                </div>
                @if(count($competitors))
                <div class="products_list">
                    @foreach($competitors as $product)
                        <div class="product_box">
                            <a href="{{ route('product', [
                                    'category' => $product->subCategory->category->slug,
                                    'subCategory' => $product->subCategory->slug,
                                    'product' => $product->slug
                                ]) }}" class="img_box">
                                <img src="{{ $product->productImages?->first()->image_file }}">
                            </a>
                            <div class="text_box">
                                <div class="competitor_title">Lorem Ipsum Dolor</div>
                                <a href="{{ route('product', [
                                    'category' => $product->subCategory->category->slug,
                                    'subCategory' => $product->subCategory->slug,
                                    'product' => $product->slug
                                ]) }}" class="product_title">{{ $product->title }}</a>
                                <a href="{{ route('products', [
                                        'category' => $product->subCategory->category->slug,
                                        'subCategory' => $product->subCategory->slug
                                    ]) }}" class="sub_category_title">{{ $product->subCategory->title }}</a>
                                <a href="{{ route('product', [
                                    'category' => $product->subCategory->category->slug,
                                    'subCategory' => $product->subCategory->slug,
                                    'product' => $product->slug
                                ]) }}" class="description">{{ $product->description }}</a>
                                <!-- <button class="red_filled_btn">Add To Enquiry</button> -->
                                <div class="add_to_cart_inputs">
                                    <div class="number_input">
                                        <button onclick="this.parentNode.querySelector('input').stepDown()">-</button>
                                        <input type="number" value="1" min="1">
                                        <button onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                                    </div>
                                    <button class="red_filled_btn add_to_cart" data-product-id="{{ $product->id }}">Add to Enquiry</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="page_links">
                    {{ $competitors->withQueryString()->links('pagination.numbers') }}
                </div>
                @else
                    <br>
                    <br>
                    <div class="title red">No results found.</div>
                @endif
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