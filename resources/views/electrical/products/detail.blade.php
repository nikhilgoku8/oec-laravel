@push('css')
<link href="{{ asset('front/assets/plugins/easyzoom/easyzoom.css') }}" rel="stylesheet" type="text/css" />
@endpush

@extends('electrical.layout.master')

@section('content')

<div class="product_detail_page">

<div class="section_one">
    <div class="container">
        <div class="inner_container">
            
            <div class="col-sm-6">
                <div class="product_images">
                    @if(!empty($product->productImages) && count($product->productImages) > 0)

                        @if(count($product->productImages) > 1)
                        <ul class="thumbnails">
                            @foreach($product->productImages as $image)
                            <li>
                                <a href="{{ $image->image_file }}" data-standard="{{ $image->image_file }}">
                                    <img src="{{ $image->image_file }}" width="110px" alt="" />
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                        
                        <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                            <a href="{{ $product->productImages[0]->image_file }}">
                                <img src="{{ $product->productImages[0]->image_file }}" alt="" />
                            </a>
                        </div>

                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="right_pane">
                    <div class="heading_pane">
                        <div class="breadcrumbs">
                            <ul>
                                <li><a class="txt" href="{{ route('electrical') }}">Home</a></li>
                                <li><a class="txt" href="{{ route('category.products', $category->slug) }}">{{ $category->title }}</a></li>
                                <li><a class="txt" href="{{ route('products', [$category->slug,$subCategory->slug]) }}">{{ $subCategory->title }}</a></li>
                                <li><span class="txt">{{ $product->title }}</span></li>
                            </ul>
                        </div>
                        <div class="other_nav">
                            <span class="adjacent_product">
                                <a href="{{ route('product', [
                                        'category' => $category->slug,
                                        'subCategory' => $subCategory->slug,
                                        'product' => $prevProduct->slug
                                    ]) }}" class="arrow"><i class="fas fa-caret-left"></i></a>
                                <span class="product_box">
                                    <a href="{{ route('product', [
                                        'category' => $category->slug,
                                        'subCategory' => $subCategory->slug,
                                        'product' => $prevProduct->slug
                                    ]) }}" class="img_box">
                                        <img src="{{ $prevProduct->productImages[0]->image_file }}">
                                    </a>
                                    <a href="{{ route('product', [
                                        'category' => $category->slug,
                                        'subCategory' => $subCategory->slug,
                                        'product' => $prevProduct->slug
                                    ]) }}" class="txt_box">{{ $prevProduct->title }}</a>
                                </span>
                            </span>
                            <!-- <a href="#" class="shop_btn"><i class="fas fa-border-all"></i></a> -->
                            <a href="#" class="shop_btn"><i class="fas fa-th-large"></i></a>
                            <span class="adjacent_product">
                                <a href="{{ route('product', [
                                        'category' => $category->slug,
                                        'subCategory' => $subCategory->slug,
                                        'product' => $nextProduct->slug
                                    ]) }}" class="arrow"><i class="fas fa-caret-right"></i></a>
                                <span class="product_box">
                                    <a href="{{ route('product', [
                                        'category' => $category->slug,
                                        'subCategory' => $subCategory->slug,
                                        'product' => $nextProduct->slug
                                    ]) }}" class="img_box">
                                        <img src="{{ $nextProduct->productImages[0]->image_file }}">
                                    </a>
                                    <a href="{{ route('product', [
                                            'category' => $category->slug,
                                            'subCategory' => $subCategory->slug,
                                            'product' => $nextProduct->slug
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
                            <button class="red_filled_btn add_to_cart" data-product-id="{{ $product->id }}">Add to Enquiry</button>
                        </div>
                        <div class="other_btns">
                            <a href="#" class="red_hollow_btn">Specifications</a>
                            <a href="#" class="red_hollow_btn">Catalog</a>
                            <a href="#" class="red_hollow_btn">Sales Drawing</a>
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
                            <a href="{{ route('product', [
                                        'category' => $row->subCategory->category->slug,
                                        'subCategory' => $row->subCategory->slug,
                                        'product' => $row->slug
                                    ]) }}" class="img_box">
                                <img src="{{ $row->productImages[0]->image_file }}">
                            </a>
                            <a href="{{ route('product', [
                                        'category' => $row->subCategory->category->slug,
                                        'subCategory' => $row->subCategory->slug,
                                        'product' => $row->slug
                                    ]) }}" class="product_title">{{ $row->title }}</a>
                            <a href="{{ route('products', [
                                        'category' => $row->subCategory->category->slug,
                                        'subCategory' => $row->subCategory->slug
                                    ]) }}" class="category_title">{{ $row->subCategory->title }}</a>
                            <!-- <a href="#" class="add_to_cart">Add To Enquiry</a> -->
                            <div class="add_to_cart_inputs">
                                <div class="number_input">
                                    <button onclick="this.parentNode.querySelector('input').stepDown()">-</button>
                                    <input type="number" value="1" min="1">
                                    <button onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                                </div>
                                <button class="red_filled_btn add_to_cart" data-product-id="{{ $row->id }}">Add to Enquiry</button>
                            </div>
                            <button class="quick_view" data-product-id="{{ $row->id }}"><i class="far fa-window-restore"></i></button>
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

</div>
<!-- product_detail_page end -->

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

<script src="{{ asset('front/assets/plugins/easyzoom/easyzoom.js') }}" type="text/javascript"></script>
<script>
$(document).ready(function() {
    // Instantiate EasyZoom instances
    var $easyzoom = $('.easyzoom').easyZoom();

    // Setup thumbnails example
    var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

    $('.thumbnails').on('click', 'a', function(e) {
        var $this = $(this);

        e.preventDefault();

        // Use EasyZoom's `swap` method
        api1.swap($this.data('standard'), $this.attr('href'));
    });
});
</script>

@push('js')

<!-- <script>
const product_images_slider = new Swiper('.product_images_slider', {
    // parallax: true,
    // effect: 'slide',
    // speed: 1000,
    slidesPerView: 1,
    loop: false,
    // Responsive breakpoints
    breakpoints: {
        // // when window width is >= 480px
        480: {
          slidesPerView: 1,
          // spaceBetween: 30
        },
        // when window width is >= 640px
        640: {
            slidesPerView: 1,
            // spaceBetween: 200,
        }
    }
});
</script> -->

@endpush

@endsection