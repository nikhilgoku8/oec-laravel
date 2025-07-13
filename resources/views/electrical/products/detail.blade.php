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
                            <span class="adjacent_product">
                                <a href="{{ route('product', [
                                        'category' => $category->slug,
                                        'subCategory' => $subCategory->slug,
                                        'product' => $prevProduct->id
                                    ]) }}" class="arrow"><i class="fas fa-caret-left"></i></a>
                                <span class="product_box">
                                    <a href="{{ route('product', [
                                        'category' => $category->slug,
                                        'subCategory' => $subCategory->slug,
                                        'product' => $prevProduct->id
                                    ]) }}" class="img_box">
                                        <img src="{{ $prevProduct->productImages[0]->image_file }}">
                                    </a>
                                    <a href="{{ route('product', [
                                        'category' => $category->slug,
                                        'subCategory' => $subCategory->slug,
                                        'product' => $prevProduct->id
                                    ]) }}" class="txt_box">{{ $prevProduct->title }}</a>
                                </span>
                            </span>
                            <!-- <a href="#" class="shop_btn"><i class="fas fa-border-all"></i></a> -->
                            <a href="#" class="shop_btn"><i class="fas fa-th-large"></i></a>
                            <span class="adjacent_product">
                                <a href="{{ route('product', [
                                        'category' => $category->slug,
                                        'subCategory' => $subCategory->slug,
                                        'product' => $nextProduct->id
                                    ]) }}" class="arrow"><i class="fas fa-caret-right"></i></a>
                                <span class="product_box">
                                    <a href="{{ route('product', [
                                        'category' => $category->slug,
                                        'subCategory' => $subCategory->slug,
                                        'product' => $nextProduct->id
                                    ]) }}" class="img_box">
                                        <img src="{{ $nextProduct->productImages[0]->image_file }}">
                                    </a>
                                    <a href="{{ route('product', [
                                            'category' => $category->slug,
                                            'subCategory' => $subCategory->slug,
                                            'product' => $nextProduct->id
                                        ]) }}" class="txt_box">{{ $nextProduct->title }}</a>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="product_info">
                        <div class="heading left">{{ $product->title }}</div>
                        <div class="description">{!! $product->description !!}</div>
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
                            <button class="red_filled_btn add_to_cart">Add to Enquiry</button>
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
<!-- section_one end -->

@if(!empty($product->productTabContents) && count($product->productTabContents) > 0)
<div class="tabs_wrapper">
    <div class="container">
        <div class="inner_container">
            
            <div class="tabs">
                <ul id="tabs-nav">
                    @foreach($product->productTabContents as $tabContent)
                    <li><a href="#tab_{{ $loop->iteration }}">{{ $tabContent->productTabLabel->title }}</a></li>
                    @endforeach
                </ul> <!-- END tabs-nav -->
                <div id="tabs-content">
                    @foreach($product->productTabContents as $tabContent)
                    <div id="tab_{{ $loop->iteration }}" class="tab-content">
                        <div class="">
                            {!! $tabContent->content !!}
                        </div>
                    </div>
                    @endforeach
                </div> <!-- END tabs-content -->
            </div> <!-- END tabs -->

        </div>
    </div>
</div>
<!-- tabs_wrapper end -->
@endif

@if(!empty($relatedProducts) && count($relatedProducts) > 0)
<div class="related_products">
    <div class="container">
        <div class="inner_container">
            
            <div class="heading">Related Products</div>

            <div class="related_products_slider products_wrapper">
                <div class="swiper-wrapper">

                    @foreach($relatedProducts as $row)
                    <div class="swiper-slide">
                        <div class="product_box">
                            <a href="#" class="img_box">
                                <img src="{{ $row->productImages[0]->image_file }}">
                            </a>
                            <a href="#" class="product_title">{{ $row->title }}</a>
                            <a href="#" class="category_title">{{ $row->subCategory->title }}</a>
                            <a href="#" class="add_to_cart">Add To Enquiry</a>
                            <a href="#" class="quick_view" data-product-id="1"><i class="far fa-window-restore"></i></a>
                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </div>
</div>
<!-- related_products end -->
@endif

<script>
// Show the first tab and hide the rest
$('#tabs-nav li:first-child').addClass('active');
$('.tab-content').hide();
$('.tab-content:first').show();

// Click function
$('#tabs-nav li').click(function(){
    $('#tabs-nav li').removeClass('active');
    $(this).addClass('active');
    $('.tab-content').hide();

    var activeTab = $(this).find('a').attr('href');
    $(activeTab).fadeIn();
    return false;
});


</script>

</div>
<!-- product_detail_page end -->

@endsection