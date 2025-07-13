@extends('electrical.layout.master')

@section('content')

<div class="product_detail_page">

<div class="section_one">
    <div class="container">
        <div class="inner_container">
            
            <div class="col-sm-6">
                <div class="product_images">
                    @if(!empty($product->productImages) && count($product->productImages) > 0)
                        @if(count($product->productImages) == 1)
                            <img src="{{ $product->productImages[0]->image_file }}">
                        @else
                            @foreach($product->productImages as $image)
                            <img src="{{ $image->image_file }}" width="50px">
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="right_pane">
                    <div class="heading_pane">
                        <div class="breadcrumbs">
                            <ul>
                                <li><a class="txt" href="{{ route('electrical') }}">Home</a></li>
                                <li><a class="txt" href="{{ route('sub-categories', $category->slug) }}">{{ $category->title }}</a></li>
                                <li><a class="txt" href="{{ route('products', [$category->slug,$subCategory->slug]) }}">{{ $subCategory->title }}</a></li>
                                <li><span class="txt">{{ $product->title }}</span></li>
                            </ul>
                        </div>
                        <div class="other_nav">
                            <a href="#" class="arrow"><i class="fas fa-caret-left"></i></a>
                            <!-- <a href="#" class="shop_btn"><i class="fas fa-border-all"></i></a> -->
                            <a href="#" class="shop_btn"><i class="fas fa-th-large"></i></a>
                            <a href="#" class="arrow"><i class="fas fa-caret-right"></i></a>
                        </div>
                    </div>
                    <div class="product_info">
                        <div class="heading left">{{ $product->title }}</div>
                        <div class="description">{{ $product->description }}</div>
                        <div class="features">
                            <div class="sub_title">Features</div>
                            <div class="features_list_wrapper">
                                {!! $product->features !!}
                            </div>
                        </div>
                        <div class="add_to_cart_inputs">
                            <div class="number_input">
                                <button onclick="this.parentNode.querySelector('input').stepDown()">-</button>
                                <input type="number" value="1" min="1">
                                <button onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                            </div>
                            <button class="red_filled_btn">Add to Enquiry</button>
                        </div>
                        <div class="other_btns">
                            <a class="red_hollow_btn">Specifications</a>
                            <a class="red_hollow_btn">Catalog</a>
                            <a class="red_hollow_btn">Sales Drawing</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clr"></div>

        </div>
    </div>
</div>
@endsection