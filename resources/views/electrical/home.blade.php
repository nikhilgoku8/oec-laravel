@extends('electrical.layout.master')

@section('content')

<div class="hero">
    <div class="video_wrapper">
        <video autoplay muted loop poster="{{ asset('front/assets/images/oec-videoframe.webp') }}">
            <!-- <source src="{{ asset('front/assets/videos/OEC.mp4') }}" type="video/mp4"> -->
        </video>
        <div class="overlay_text wow zoomIn" data-wow-delay="0.1s">LEADING MANUFACTURER OF <br> ELECTRICAL AND AUTOMOTIVE SOLUTIONS</div>
    </div>
</div>

@endsection