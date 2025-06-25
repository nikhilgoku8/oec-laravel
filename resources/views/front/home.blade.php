@extends('front.layout.master')

@section('content')

<div class="hero">
    <div class="video_wrapper">
        <video autoplay muted loop>
            <source src="{{ asset('front/assets/videos/OEC.mp4') }}" type="video/mp4">
        </video>
        <div class="overlay_text">LEADING MANUFACTURER OF <br> ELECTRICAL AND AUTOMOTIVE SOLUTIONS</div>
    </div>
</div>

<div class="about">
    <div class="container">
        <div class="inner_container">
            
            <div class="heading">The Complete Manufacturer</div>

            <div class="inner_box">
                <div class="col-sm-6">
                    <div class="text_box">
                        <div class="title">About OEC</div>
                        <p>OEC was established in 1974 and is a family-owned, global leader in the manufacturing of electrical connectors, fittings, cable glands, automotive fittings, air brake tubing, and hoses. Over the last 50 years, OEC has consistently expanded its product portfolio to cater to the diverse needs of the electrical and automotive industries across the globe. </p>
                        <a href="#" class="hollow_btn">Read More</a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="rings_wrapper">
                        <div class="ring_box">
                            <div class="ring">
                                <span class="lil_big">700,000</span>
                                <span class="lil_small">SQ.FT of Manufacturing</span>
                            </div>
                        </div>
                        <div class="ring_box">
                            <div class="ring">
                                <span class="lil_big">15,000 +</span>
                                <span class="lil_small">SKU’s</span>
                            </div>
                        </div>
                        <div class="ring_box">
                            <div class="ring">
                                <span class="lil_big">100 +</span>
                                <span class="lil_small">Countries</span>
                            </div>
                        </div>
                        <div class="ring_box">
                            <div class="ring">
                                <span class="lil_big">2,100 +</span>
                                <span class="lil_small">Employees</span>
                            </div>
                        </div>
                        <div class="ring_box">
                            <div class="ring">
                                <span class="lil_big">5</span>
                                <span class="lil_small">Facilities</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clr"></div>
            </div>

            <div class="video_wrapper">
                <video autoplay muted loop>
                    <source src="{{ asset('front/assets/videos/about.mp4') }}" type="video/mp4">
                </video>
            </div>

        </div>
    </div>
</div>

@endsection