@extends('electrical.layout.master')

@section('content')

<div class="hero">
    <div class="video_wrapper">
        <video autoplay muted loop poster="https://placehold.co/1920x600/?text=Slider">
            <source src="" type="video/mp4">
        </video>
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
                            <a href="#">
                                <img src="{{ asset('electrical-assets/images/our-brands/duracrimp.png') }}">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="#">
                                <img src="{{ asset('electrical-assets/images/our-brands/orion.png') }}">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="#">
                                <img src="{{ asset('electrical-assets/images/our-brands/terrafix.png') }}">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="#">
                                <img src="{{ asset('electrical-assets/images/our-brands/series-e.png') }}">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="#">
                                <img src="{{ asset('electrical-assets/images/our-brands/dry-shield.png') }}">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="#">
                                <img src="{{ asset('electrical-assets/images/our-brands/unisteel.png') }}">
                            </a>
                        </div>
                    </div>

                </div>
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
                            <a href="#">
                                <img src="{{ asset('electrical-assets/images/featured-categories/compression.png') }}">
                                <span>Compression</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="#">
                                <img src="{{ asset('electrical-assets/images/featured-categories/mechanical.png') }}">
                                <span>Mechanical</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="#">
                                <img src="{{ asset('electrical-assets/images/featured-categories/insulated.png') }}">
                                <span>Insulated</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="#">
                                <img src="{{ asset('electrical-assets/images/featured-categories/grounding.png') }}">
                                <span>Grounding</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="#">
                                <img src="{{ asset('electrical-assets/images/featured-categories/conduit-body.png') }}">
                                <span>Conduit Bodies</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="#">
                                <img src="{{ asset('electrical-assets/images/featured-categories/weatherproof.png') }}">
                                <span>Weatherproof Products</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="#">
                                <img src="{{ asset('electrical-assets/images/featured-categories/fittings.png') }}">
                                <span>Fittings</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="#">
                                <img src="{{ asset('electrical-assets/images/featured-categories/service-entrance.png') }}">
                                <span>Service Entrance</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="#">
                                <img src="{{ asset('electrical-assets/images/featured-categories/ac.png') }}">
                                <span>Junctions Boxes</span>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item_box">
                            <a href="#">
                                <img src="{{ asset('electrical-assets/images/featured-categories/cable-glands.png') }}">
                                <span>Cable Glands</span>
                            </a>
                        </div>
                    </div>

                </div>
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
                @for($i=1 ; $i<=2; $i++)
                <div class="product_box">
                    <a href="#" class="img_box">
                        <img src="https://oec-americas.com/electrical/wp-content/uploads/2024/10/FS152-1.png">
                    </a>
                    <a href="#" class="product_title">asdasd</a>
                    <a href="#" class="category_title">asdasd</a>
                    <a href="#" class="add_to_cart">Add To Enquiry</a>
                    <a href="#" class="quick_view" data-product-id="1"><i class="far fa-eye"></i></a>
                </div>
                <div class="product_box">
                    <a href="#" class="img_box">
                        <img src="https://oec-americas.com/electrical/wp-content/uploads/2024/10/ELC050THCG-1-263x300.webp">
                    </a>
                    <a href="#" class="product_title">asdasd</a>
                    <a href="#" class="category_title">asdasd</a>
                    <a href="#" class="add_to_cart">Add To Enquiry</a>
                    <a href="#" class="quick_view" data-product-id="1"><i class="fas fa-expand"></i></a>
                </div>
                <div class="product_box">
                    <a href="#" class="img_box">
                        <img src="https://oec-americas.com/electrical/wp-content/uploads/2024/10/FS152-1.png">
                    </a>
                    <a href="#" class="product_title">asdasd</a>
                    <a href="#" class="category_title">asdasd</a>
                    <a href="#" class="add_to_cart">Add To Enquiry</a>
                    <a href="#" class="quick_view" data-product-id="1"><i class="far fa-window-restore"></i></a>
                </div>
                <div class="product_box">
                    <a href="#" class="img_box">
                        <img src="https://oec-americas.com/electrical/wp-content/uploads/2024/10/ELC050THCG-1-263x300.webp">
                    </a>
                    <a href="#" class="product_title">asdasd</a>
                    <a href="#" class="category_title">asdasd</a>
                    <a href="#" class="add_to_cart">Add To Enquiry</a>
                    <a href="#" class="quick_view" data-product-id="1"><i class="fas fa-expand-arrows-alt"></i></a>
                </div>
                <div class="product_box">
                    <a href="#" class="img_box">
                        <img src="https://oec-americas.com/electrical/wp-content/uploads/2024/10/ELC050THCG-1-263x300.webp">
                    </a>
                    <a href="#" class="product_title">asdasd</a>
                    <a href="#" class="category_title">asdasd</a>
                    <a href="#" class="add_to_cart">Add To Enquiry</a>
                    <a href="#" class="quick_view" data-product-id="1"><i class="far fa-clone"></i></a>
                </div>
                @endfor
            </div>

        </div>
    </div>
</div>
<!-- featured_products end -->

@endsection