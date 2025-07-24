@extends('electrical.layout.master')

@section('content')

<div class="industries_page commercial_industrial">
    
<div class="section_one">
    <div class="container">
        <div class="inner_container">
            
            <div class="heading">
                <span>Energy Systems & Renewables</span>
            </div>

            <div class="video_wrapper">
                <video autoplay muted loop poster="https://placehold.co/1200x400/?text=video">
                    <source src="" type="video/mp4">
                </video>
            </div>

            <div class="text_box center">
                <p>At OEC, we specialize in manufacturing a wide range of electrical products for Energy Systems & Renewables. Our products are designed to ensure safe and efficient power management in solar, wind, and other renewable energy applications. Electrical components play a vital role in energy storage, power conversion, and distribution. From durable connectors to weatherproof enclosures, our solutions ensure reliable performance in challenging environments. OEC's advanced products support sustainable energy systems, maximizing efficiency and promoting a greener future.</p>
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

            @include('electrical.includes.industries-slider')

        </div>
    </div>
</div>
<!-- section_two end -->

</div>
<!-- industries_page end -->

@endsection