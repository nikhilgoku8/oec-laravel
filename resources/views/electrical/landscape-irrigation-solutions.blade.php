@extends('electrical.layout.master')

@section('content')

<div class="industries_page commercial_industrial">
    
<div class="section_one">
    <div class="container">
        <div class="inner_container">
            
            <div class="heading">
                <span>Landscape & Irrigation Solutions</span>
            </div>

            <div class="video_wrapper">
                <video autoplay muted loop poster="https://placehold.co/1200x400/?text=video">
                    <source src="" type="video/mp4">
                </video>
            </div>

            <div class="text_box center">
                <p>At OEC, we specialize in manufacturing a wide range of electrical products tailored for Landscape & Irrigation Solutions. Our products ensure reliable performance in outdoor environments, offering safety, durability, and efficiency. Electrical components are essential for powering irrigation systems, outdoor lighting, and automation controls. From weatherproof fittings to grounding solutions, we provide products that enhance system reliability and protect against environmental factors. OEC's innovative solutions help optimize water usage, improve landscape aesthetics, and ensure long-lasting performance.</p>
            </div>

        </div>
    </div>
</div>
<!-- section_one end -->
    
<div class="section_two">
    <div class="container">
        <div class="inner_container">
            
            <div class="heading back_stroke">
                <span>We Provide High-Quality Electrical Products for Landscape & Irrigation Solutions</span>
            </div>

            <div class="industries_slider">
                <div class="swiper-wrapper">

                    @for($i=1; $i<=10; $i++)
                    <div class="swiper-slide">
                        <div class="item_box">
                            <div class="img_box">
                                <img src="{{ asset('electrical-assets/images/sub-categories/1.webp') }}">
                            </div>
                            <div class="category_title">Category 1</div>
                            <div class="sub_category_title">Sub_Category 1</div>
                            <a href="#" class="red_filled_btn">View Products</a>
                        </div>
                    </div>
                    @endfor

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
            <!-- industries_slider end -->

        </div>
    </div>
</div>
<!-- section_two end -->

</div>
<!-- industries_page end -->

@endsection