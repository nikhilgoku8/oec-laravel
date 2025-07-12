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
                <div class="product_info">
                    <div class="heading left">{{ $product->title }}</div>
                    <div class="description">{{ $product->description }}</div>
                    <div class="features">
                        <div class="sub_title">Features</div>
                        <div class="features_list_wrapper">
                            {!! $product->features !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="clr"></div>

        </div>
    </div>
</div>
@endsection