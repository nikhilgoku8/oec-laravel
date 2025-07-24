@extends('electrical.layout.master')

@section('content')

<div class="industries_page commercial_industrial">
    
<div class="section_one">
    <div class="container">
        <div class="inner_container">
            
            <div class="heading">
                <span>Commercial and Industrial</span>
            </div>

            <div class="video_wrapper">
                <video autoplay muted loop poster="https://placehold.co/1200x400/?text=video">
                    <source src="" type="video/mp4">
                </video>
            </div>

            <div class="text_box center">
                <p>At OEC, we specialize in manufacturing a wide range of electrical products designed to meet the needs of both commercial and industrial sectors. Our products are built to ensure safety, durability, and efficiency across various applications. Electrical products are the backbone of both commercial and industrial infrastructures, providing safe, efficient, and reliable power solutions. Whether for lighting, power distribution, machinery operation, or renewable energy systems, these products ensure that both sectors run smoothly and safely.</p>
            </div>

        </div>
    </div>
</div>
<!-- section_one end -->
    
<div class="section_two">
    <div class="container">
        <div class="inner_container">
            
            <div class="heading back_stroke">
                <span>We Provide High-Quality Electrical Products for Commercial and Industrial</span>
            </div>

            @include('electrical.includes.industries-slider')

        </div>
    </div>
</div>
<!-- section_two end -->

</div>
<!-- industries_page end -->

@endsection