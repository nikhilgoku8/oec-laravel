@extends('electrical.layout.master')

@section('content')

<div class="hero">
    <!-- <div class="video_wrapper">
        <video autoplay muted loop poster="https://placehold.co/1920x600/?text=Slider">
            <source src="" type="video/mp4">
        </video>
    </div> -->
    <div class="main_hero_slider">
        <div class="swiper-wrapper">

            @foreach($categories as $category)
            <div class="swiper-slide">
                <a href="{{ route('category.products', $category->slug) }}">
                    <span class="category_title">{{$category->title}}</span>
                    <!-- <img src="{{ $category->subCategories->first()->products->first()->productImages->first()->image_file }}"> -->
                    <span class="image_wrapper">
                        @foreach($category->subCategories as $subCategory)
                            @if($subCategory->products->first()?->productImages->first()->image_file)
                            <span class="img_box">
                                <img src="{{ $subCategory->products->first()?->productImages->first()->image_file }}">
                            </span>
                            @endif
                            @if($loop->iteration == 4) @break @endif
                        @endforeach
                    </span>
                </a>
            </div>
            @endforeach
            <!-- <div class="swiper-slide">
                <div class="item_box">
                    <a href="{{ route('category.products', 'insulated') }}">
                        <img src="{{ asset('electrical-assets/images/our-brands/orion.png') }}">
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="item_box">
                    <a href="{{ route('category.products', 'grounding') }}">
                        <img src="{{ asset('electrical-assets/images/our-brands/terrafix.png') }}">
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="item_box">
                    <a href="{{ route('category.products', 'conduit-bodies') }}">
                        <img src="{{ asset('electrical-assets/images/our-brands/series-e.png') }}">
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="item_box">
                    <a href="{{ route('category.products', 'weatherproof-products') }}">
                        <img src="{{ asset('electrical-assets/images/our-brands/dry-shield.png') }}">
                    </a>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="item_box">
                    <a href="{{ route('category.products', 'fittings') }}">
                        <img src="{{ asset('electrical-assets/images/our-brands/unisteel.png') }}">
                    </a>
                </div>
            </div> -->

        </div>
        <div class="swiper-pagination"></div>
    </div>

</div>

<div class="our_brands">
    <!-- <div class="container"> -->
        <div class="inner_container">
            
            <div class="heading back_stroke">
                <span>Our Brands</span>
            </div>

            <div class="our_brands_slider">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'compression') }}">
                                <img src="{{ asset('electrical-assets/images/our-brands/duracrimp.png') }}">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'insulated') }}">
                                <img src="{{ asset('electrical-assets/images/our-brands/orion.png') }}">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'grounding') }}">
                                <img src="{{ asset('electrical-assets/images/our-brands/terrafix.png') }}">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'conduit-bodies') }}">
                                <img src="{{ asset('electrical-assets/images/our-brands/series-e.png') }}">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'weatherproof-products') }}">
                                <img src="{{ asset('electrical-assets/images/our-brands/dry-shield.png') }}">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'fittings') }}">
                                <img src="{{ asset('electrical-assets/images/our-brands/unisteel.png') }}">
                            </a>
                        </div>
                    </div>

                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    <!-- </div> -->
</div>
<!-- our_brands end -->

<div class="featured_categories">
    <!-- <div class="container"> -->
        <div class="inner_container">
            
            <div class="heading back_stroke">
                <span>Featured Categories</span>
            </div>

            <div class="featured_categories_slider">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'compression') }}">
                                <img src="{{ asset('electrical-assets/images/featured-categories/compression.png') }}">
                                <span>Compression</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'mechanical') }}">
                                <img src="{{ asset('electrical-assets/images/featured-categories/mechanical.png') }}">
                                <span>Mechanical</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'insulated') }}">
                                <img src="{{ asset('electrical-assets/images/featured-categories/insulated.png') }}">
                                <span>Insulated</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'grounding') }}">
                                <img src="{{ asset('electrical-assets/images/featured-categories/grounding.png') }}">
                                <span>Grounding</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'conduit-bodies') }}">
                                <img src="{{ asset('electrical-assets/images/featured-categories/conduit-body.png') }}">
                                <span>Conduit Bodies</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'weatherproof-products') }}">
                                <img src="{{ asset('electrical-assets/images/featured-categories/weatherproof.png') }}">
                                <span>Weatherproof Products</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'fittings') }}">
                                <img src="{{ asset('electrical-assets/images/featured-categories/fittings.png') }}">
                                <span>Fittings</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'service-entrance') }}">
                                <img src="{{ asset('electrical-assets/images/featured-categories/service-entrance.png') }}">
                                <span>Service Entrance</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'junctions-boxes') }}">
                                <img src="{{ asset('electrical-assets/images/featured-categories/ac.png') }}">
                                <span>Junctions Boxes</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="{{ route('category.products', 'cable-glands') }}">
                                <img src="{{ asset('electrical-assets/images/featured-categories/cable-glands.png') }}">
                                <span>Cable Glands</span>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    <!-- </div> -->
</div>
<!-- featured_categories end -->

<div class="featured_products">
    <div class="container">
        <div class="inner_container">
            
            <div class="heading back_stroke">
                <span>Featured Products</span>
            </div>

            <div class="products_wrapper">
                @foreach($featuredProducts as $row)
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
                        <div class="add_to_cart_inputs">
                            <!-- <div class="number_input">
                                <button onclick="this.parentNode.querySelector('input').stepDown()">-</button>
                                <input type="number" value="1" min="1">
                                <button onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                            </div> -->
                            <button class="red_filled_btn add_to_cart" data-product-id="{{ $row->id }}">Add to Enquiry</button>
                        </div>
                        <button class="quick_view" data-product-id="{{ $row->id }}"><i class="far fa-window-restore"></i></button>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
<!-- featured_products end -->

@endsection