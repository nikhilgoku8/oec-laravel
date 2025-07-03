@extends('electrical.layout.master')

@section('content')

<div class="hero">
    <div class="video_wrapper">
        <video autoplay muted loop poster="{{ asset('front/assets/images/oec-videoframe.webp') }}">
            <source src="{{ asset('front/assets/videos/OEC.mp4') }}" type="video/mp4">
        </video>
        <div class="overlay_text wow zoomIn" data-wow-delay="0.1s">LEADING MANUFACTURER OF <br> ELECTRICAL AND AUTOMOTIVE SOLUTIONS</div>
    </div>
</div>

<div class="about">
    <div class="container">
        <div class="inner_container">
            
            <div class="heading small wow fadeIn" data-wow-delay="0.0s">The Complete Manufacturer</div>

            <div class="inner_box">
                <div class="col-sm-6">
                    <div class="text_box wow fadeInLeft" data-wow-delay="0.1s">
                        <div class="title">About OEC</div>
                        <p>OEC was established in 1974 and is a family-owned, global leader in the manufacturing of electrical connectors, fittings, cable glands, automotive fittings, air brake tubing, and hoses. Over the last 50 years, OEC has consistently expanded its product portfolio to cater to the diverse needs of the electrical and automotive industries across the globe. </p>
                        <a href="{{ route('overview') }}" class="hollow_btn">Read More</a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="rings_wrapper">
                        <div class="ring_box wow zoomIn">
                            <div class="ring">
                                <span class="lil_big"><span class="counter" data-target="700000">0</span> +</span>
                                <span class="lil_small">SQ.FT of Manufacturing</span>
                            </div>
                        </div>
                        <div class="ring_box wow zoomIn">
                            <div class="ring">
                                <span class="lil_big"><span class="counter" data-target="15000">0</span> +</span>
                                <span class="lil_small">SKU’s</span>
                            </div>
                        </div>
                        <div class="ring_box wow zoomIn">
                            <div class="ring">
                                <span class="lil_big"><span class="counter" data-target="100">0</span> +</span>
                                <span class="lil_small">Countries</span>
                            </div>
                        </div>
                        <div class="ring_box wow zoomIn">
                            <div class="ring">
                                <span class="lil_big"><span class="counter" data-target="2100">0</span> +</span>
                                <span class="lil_small">Employees</span>
                            </div>
                        </div>
                        <div class="ring_box wow zoomIn">
                            <div class="ring">
                                <span class="lil_big"><span class="counter" data-target="5">0</span></span>
                                <span class="lil_small">Facilities</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clr"></div>
            </div>

            <div class="video_wrapper wow fadeIn" data-wow-delay="0.1s">
                <video autoplay muted loop>
                    <source src="{{ asset('front/assets/videos/about.mp4') }}" type="video/mp4">
                </video>
            </div>

        </div>
    </div>
</div>
<!-- about end -->

<div class="innovation">
    <div class="container">
        <div class="inner_container">
            
            <div class="heading wow fadeIn" data-wow-delay="0.0s">Innovation</div>

            <div class="title wow fadeInUp" data-wow-delay="0.0s">Products</div>
            <p class=" wow fadeInUp" data-wow-delay="0.2s">OEC's comprehensive and diverse product portfolio is rigorously tested and certified to meet global standards, ensuring bespoke quality and durability. </p>

            <div class="products_wrapper">
                <div class="col-sm-6">
                    <div class="product_box wow fadeInLeft" data-wow-delay="0.1s">
                        <div class="img_box">
                            <img src="{{ asset('front/assets/images/homepage/electricals.webp') }}">
                        </div>
                        <div class="text_box">
                            <div class="title">Electrical</div>
                            <div class="hidden_txt">
                                <p>OEC designs and manufactures a wide range of UL-listed electrical products including connectors, fittings, and boxes.</p>
                                <a href="#" class="hollow_btn">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="product_box wow fadeInRight" data-wow-delay="0.1s">
                        <div class="img_box">
                            <img src="{{ asset('front/assets/images/homepage/automotive.webp') }}">
                        </div>
                        <div class="text_box">
                            <div class="title">Automotive</div>
                            <div class="hidden_txt">
                                <p>OEC designs and manufactures a variety of fittings, tubing, and hoses for the heavy-duty trucking industry.</p>
                                <a href="#" class="hollow_btn">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clr"></div>
            </div>

        </div>
    </div>
</div>
<!-- innovation end -->

<script>
$(document).ready(function() {
    $('.innovation .product_box')
    .on('mouseenter', function() {
        $(this)
            .find('.hidden_txt')
            .stop(true, true) // This is to clear animation queue
            .slideDown();
    })
    .on('mouseleave', function() {
        $(this)
            .find('.hidden_txt')
            .stop(true, true)
            .slideUp();
    });
});
</script>

<div class="home_parallex">
    <div class="img_box wow fadeInRight" data-wow-delay="0.0s">
        <img src="{{ asset('front/assets/images/bg/parallax-logo.webp') }}">
    </div>
</div>
<!-- home_parallex end -->

<div class="markets">
    <div class="container">
        <div class="inner_container">
            
            <div class="heading wow fadeIn" data-wow-delay="0.0s">Markets</div>

            <div class="text_box">
                <div class="title wow fadeInUp" data-wow-delay="0.0s">Markets</div>
                <p class=" wow fadeInUp" data-wow-delay="0.2s">For the utility, OEM, commercial, renewable, and industrial markets, OEC innovates & certifies products that meet emerging demands.</p>
                <a href="#" class="hollow_btn wow fadeInUp" data-wow-delay="0.3s">Read More</a>
            </div>

            <div class="video_wrapper wow fadeIn" data-wow-delay="0.1s">
                <video autoplay muted loop>
                    <source src="{{ asset('front/assets/videos/markets.mp4') }}" type="video/mp4">
                </video>
            </div>

        </div>
    </div>
</div>
<!-- markets end -->

<div class="why_oec">
    <div class="container">
        <div class="inner_container">
            
            <div class="heading wow fadeIn" data-wow-delay="0.0s">Why OEC</div>

            <div class="text_box">
                <div class="title wow fadeInUp" data-wow-delay="0.0s">Why Us</div>
                <p class=" wow fadeInUp" data-wow-delay="0.2s">As an industry leader with half a century of proven expertise, we bring you a diverse portfolio of over 15000 SKUs, backed by cutting-edge manufacturing, a skilled workforce of 2100, and a strong emphasis on R&D. We are proud to say that over 91% of OEC products are manufactured in-house. We go beyond mere products, delivering comprehensive solutions tailored to meet your electrical and automotive requirements.</p>
                <!-- <a href="#" class="hollow_btn">Read More</a> -->
            </div>
            <div class="img_box wow fadeInUp" data-wow-delay="0.2s">
                <img src="{{ asset('front/assets/images/homepage/whyusimg.webp') }}">
            </div>

            <!-- <div class="video_wrapper wow fadeIn" data-wow-delay="0.1s">
                <video autoplay muted loop>
                    <source src="" type="video/mp4">
                </video>
            </div> -->

        </div>
    </div>
</div>
<!-- markets end -->

<div class="sustainability">
    <div class="container">
        <div class="inner_container">
            
            <div class="heading wow fadeIn" data-wow-delay="0.0s">Sustainability</div>

            <div class="text_box">
                <div class="title wow fadeInUp" data-wow-delay="0.0s">Sustainability</div>
                <p class=" wow fadeInUp" data-wow-delay="0.2s">Ensuring a Greener and Brighter Tomorrow!</p>
                <a href="#" class="hollow_btn wow fadeInUp" data-wow-delay="0.3s">Read More</a>
            </div>

            <div class="video_wrapper wow fadeIn" data-wow-delay="0.1s">
                <video autoplay muted loop>
                    <source src="{{ asset('front/assets/videos/sustainability.mp4') }}" type="video/mp4">
                </video>
            </div>

        </div>
    </div>
</div>
<!-- sustainability end -->

@endsection