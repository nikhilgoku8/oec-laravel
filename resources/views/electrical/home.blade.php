@extends('electrical.layout.master')

@section('content')

<!-- <div class="hero">
    <div class="video_wrapper">
        <video autoplay muted loop poster="{{ asset('front/assets/images/oec-videoframe.webp') }}">
            <source src="{{ asset('front/assets/videos/OEC.mp4') }}" type="video/mp4">
        </video>
        <div class="overlay_text wow zoomIn" data-wow-delay="0.1s">LEADING MANUFACTURER OF <br> ELECTRICAL AND AUTOMOTIVE SOLUTIONS</div>
    </div>
</div> -->

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
<!-- our_brands end -->

@endsection